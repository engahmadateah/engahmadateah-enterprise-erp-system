<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $conversations = auth()
            ->user()
            ->conversations()
            ->with('users')
            ->latest()
            ->get();

        return view(
            'chat.index',
            compact('conversations')
        );
    }

    public function show(Conversation $conversation)
    {
        // التأكد أن المستخدم ضمن المحادثة
        abort_unless(
            $conversation
                ->users()
                ->where('users.id', auth()->id())
                ->exists(),
            403
        );
    
        // تعليم الرسائل الواردة غير المقروءة كمقروءة
        $conversation
            ->messages()
            ->where('user_id', '!=', auth()->id())
            ->where('is_read', false)
            ->update([
                'is_read' => true
            ]);
    
        // تحميل الرسائل مع صاحب كل رسالة
        $messages = $conversation
            ->messages()
            ->with('user')
            ->oldest()
            ->get();
    
        // إعادة الصفحة
        return view(
            'chat.show',
            compact(
                'conversation',
                'messages'
            )
        );
    }

    public function send(
        Request $request,
        Conversation $conversation
    )
    {
        $request->validate([

            'message' => 'nullable|string',

            'attachment' => 'nullable|file|max:10240'

        ]);

        if (
            empty($request->message)
            &&
            !$request->hasFile('attachment')
        ) {

            return back();
        }

        $filePath = null;

        if ($request->hasFile('attachment')) {

            $filePath = $request
                ->file('attachment')
                ->store(
                    'chat-files',
                    'public'
                );
        }

        Message::create([

            'conversation_id' => $conversation->id,

            'user_id' => auth()->id(),

            'message' => $request->message,

            'attachment' => $filePath

        ]);

        return back();
    }

    public function users(Request $request)
    {
        $users = User::where(
                'id',
                '!=',
                auth()->id()
            )
            ->when(
                $request->search,
                function ($q) use ($request) {

                    $q->where(
                        'name',
                        'like',
                        '%' . $request->search . '%'
                    );
                }
            )
            ->orderBy('name')
            ->get();

        return view(
            'chat.users',
            compact('users')
        );
    }

    public function start(User $user)
    {
        $myId = auth()->id();

        $conversation = Conversation::where(
                'type',
                'private'
            )
            ->whereHas(
                'users',
                function ($q) use ($myId) {

                    $q->where(
                        'users.id',
                        $myId
                    );
                }
            )
            ->whereHas(
                'users',
                function ($q) use ($user) {

                    $q->where(
                        'users.id',
                        $user->id
                    );
                }
            )
            ->first();

        if (!$conversation) {

            $conversation = Conversation::create([

                'type' => 'private'

            ]);

            $conversation
                ->users()
                ->attach([

                    $myId,

                    $user->id

                ]);
        }

        return redirect()->route(
            'chat.show',
            $conversation
        );
    }
}