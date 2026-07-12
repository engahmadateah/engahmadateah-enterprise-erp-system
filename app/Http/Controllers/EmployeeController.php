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
        DB::transaction(function () use ($request) {

            $lastEmployee = Employee::latest()
                ->first();

            $number = $lastEmployee
                ? $lastEmployee->id + 1
                : 1;

            $employeeNo = 'EMP-' .
                str_pad(
                    $number,
                    5,
                    '0',
                    STR_PAD_LEFT
                );

            $avatar = null;

            if ($request->hasFile('avatar')) {

                $avatar = $request
                    ->file('avatar')
                    ->store(
                        'employees',
                        'public'
                    );
            }

            $user = User::create([

                'name' =>
                    $request->first_name . ' ' .
                    $request->last_name,

                'email' =>
                    $request->email,

                'phone' =>
                    $request->phone,

                'password' =>
                    Hash::make('12345678'),

                'is_active' => true,

            ]);

            $user->assignRole(
                'Employee'
            );

            $employee = Employee::create([

                'user_id' => $user->id,

                'employee_no' =>
                    $employeeNo,

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

                'join_date' =>
                    $request->join_date,

                'avatar' =>
                    $avatar,

                'annual_leave_balance' => 21,

                'is_active' => true,

            ]);

            LeaveBalance::create([

                'employee_id' => $employee->id,
            
                'annual_balance' => 21,
            
                'used_balance' => 0,
            
                'remaining_balance' => 21,
            
            ]);
        });

        return redirect()
            ->route('employees.index')
            ->with(
                'success',
                'Employee Created Successfully'
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

            'employee_no' => 'required',

            'first_name' => 'required',

            'last_name' => 'required',

            'email' => 'nullable|email',

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

            $employee->user->update([

                'name' =>
                    $request->first_name . ' ' .
                    $request->last_name,

                'email' =>
                    $request->email,

                'phone' =>
                    $request->phone,

                'is_active' =>
                    $request->has('is_active'),

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
        if ($employee->user) {

            $employee->user->delete();
        }

        $employee->delete();

        return redirect()
            ->route('employees.index')
            ->with(
                'success',
                'Employee Deleted Successfully'
            );
    }
}