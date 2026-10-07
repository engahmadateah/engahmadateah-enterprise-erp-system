<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\User;
use App\Http\Requests\StoreEmployeeRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\LeaveBalance;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
{
    $search = request('search');

    $employees = Employee::with('department')
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('employee_no', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhereHas('department', function ($departmentQuery) use ($search) {
                      $departmentQuery->where('name', 'like', "%{$search}%");
                  });
            });
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('employees.index', compact('employees'));
}

    public function create()
    {
        $departments = Department::all();

        return view(
            'employees.create',
            compact('departments')
        );
    }

    public function store(
        StoreEmployeeRequest $request
    )
    {
        // random temporary password (was a hard-coded "12345678" for everyone)
        $tempPassword = Str::random(10);

        DB::transaction(function () use ($request, $tempPassword) {

            // placeholder, replaced by the id based number right after the insert
            // (max(id)+1 produced duplicates when two admins saved at once)
            $employeeNo = 'TMP-' . Str::random(12);

            $avatar = null;

            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar')->store('employees', 'public');
            }

            $user = User::create([
                'name'      => $request->first_name . ' ' . $request->last_name,
                'email'     => $request->email,
                'phone'     => $request->phone,
                'password'  => Hash::make($tempPassword),
                'is_active' => true,
            ]);

            $user->assignRole('Employee');

            $employee = Employee::create([
                'user_id'              => $user->id,
                'employee_no'          => $employeeNo,
                'department_id'        => $request->department_id,
                'first_name'           => $request->first_name,
                'last_name'            => $request->last_name,
                'email'                => $request->email,
                'phone'                => $request->phone,
                'position'             => $request->position,
                'salary'               => $request->salary,
                'join_date'            => $request->join_date,
                'avatar'               => $avatar,
                'annual_leave_balance' => 21,
                'is_active'            => true,
            ]);

            $employee->update([
                'employee_no' => 'EMP-' . str_pad($employee->id, 5, '0', STR_PAD_LEFT),
            ]);

            LeaveBalance::create([
                'employee_id'       => $employee->id,
                'annual_balance'    => 21,
                'used_balance'      => 0,
                'remaining_balance' => 21,
            ]);
        });

        return redirect()
            ->route('employees.index')
            ->with(
                'success',
                'Employee Created Successfully. Temporary password (shown once): '
                    . $tempPassword
            );
    }

    public function edit(
        Employee $employee
    )
    {
        $departments = Department::all();

        return view(
            'employees.edit',
            compact(
                'employee',
                'departments'
            )
        );
    }

    public function update(
        Request $request,
        Employee $employee
    )
    {
        $request->validate([
            'employee_no' => [
                'required',
                Rule::unique('employees', 'employee_no')->ignore($employee->id),
            ],
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'phone'         => 'nullable|string|max:50',
            'position'      => 'nullable|string|max:100',
            'email'         => [
                'required',
                'email',
                Rule::unique('employees', 'email')->ignore($employee->id),
                Rule::unique('users', 'email')->ignore($employee->user_id),
            ],
            'department_id' => 'required|exists:departments,id',
            'salary'        => 'required|numeric|min:0|max:999999999',
        ]);

        $employee->update([

            'employee_no' =>
                $request->employee_no,

            'department_id' =>
                $request->department_id,

            'first_name' =>
                $request->first_name,

            'last_name' =>
                $request->last_name,

            'email' =>
                $request->email,

            'phone' =>
                $request->phone,

            'position' =>
                $request->position,

            'salary' =>
                $request->salary,

            'is_active' =>
                $request->has('is_active'),

        ]);

        if ($employee->user) {
            $keepActive = $employee->user->id === auth()->id()
                || $employee->user->hasRole('Super Admin');

            $employee->user->update([

                'name' =>
                    $request->first_name . ' ' .
                    $request->last_name,

                'email' =>
                    $request->email,

                'phone' =>
                    $request->phone,

                'is_active' =>
                    $keepActive ? true : $request->has('is_active'),
            ]);
        }

        return redirect()
            ->route('employees.index')
            ->with(
                'success',
                'Employee Updated Successfully'
            );
    }

    public function destroy(
        Employee $employee
    )
    {
        $linked = $employee->user;

        if ($linked && ($linked->id === auth()->id() || $linked->hasRole('Super Admin'))) {
            return back()->with('error', 'This employee is linked to a protected account.');
        }

        $avatar = $employee->avatar;

        DB::transaction(function () use ($employee) {

            $user = $employee->user;

            $employee->delete();

            if ($user) {
                $user->delete();
            }
        });

        // only after the DB delete succeeded
        if ($avatar) {
            Storage::disk('public')->delete($avatar);
        }

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee Deleted Successfully');
    }
}
