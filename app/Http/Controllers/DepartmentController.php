<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $departments = Department::paginate(10);
        return view('admin.departments', compact('departments', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        Department::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.departments')
            ->with('success', 'Department created successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $department->update([
            'name' => $request->name,
        ]);
        
        return redirect()->route('admin.departments')
            ->with('success', 'Department updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        if ($department->doctors->count() > 0) {
            return redirect()->route('admin.departments')
                ->with('error', 'Cannot delete department with assigned doctors');
        }

        $department->delete();

        return redirect()->route('admin.departments')
            ->with('success', 'Department deleted successfully');
    }
}
