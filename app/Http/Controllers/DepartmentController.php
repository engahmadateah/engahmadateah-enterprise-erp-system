<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;


class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Department::query();
    
        if ($request->filled('search')) {
    
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
    
        }
    
        $departments = $query->latest()->paginate(10);
    
        return view('departments.index', [
    
            'departments' => $departments,
    
            'totalDepartments' => Department::count(),
    
            'activeDepartments' => Department::where('is_active', 1)->count(),
    
            'inactiveDepartments' => Department::where('is_active', 0)->count(),
    
        ]);
    }
    public function create()
{
    return view(
        'departments.create'
    );
}
public function store(
    StoreDepartmentRequest $request
)
{
    Department::create([

        'name' => $request->name,

        'code' => $request->code,

        'description' => $request->description,

        'is_active' => true,

    ]);

    return redirect()
        ->route('departments.index')
        ->with(
            'success',
            'Department Created Successfully'
        );
}
public function edit(
    Department $department
)
{
    return view(
        'departments.edit',
        compact('department')
    );
}
public function update(
    UpdateDepartmentRequest $request,
    Department $department
)
{
    $department->update([

        'name' => $request->name,

        'code' => $request->code,

        'description' => $request->description,

        'is_active' => $request->has(
            'is_active'
        ),

    ]);

    return redirect()
        ->route('departments.index')
        ->with(
            'success',
            'Department Updated Successfully'
        );
}
public function destroy(
    Department $department
)
{
    $department->delete();

    return back()->with(
        'success',
        'Department Deleted Successfully'
    );
}
}