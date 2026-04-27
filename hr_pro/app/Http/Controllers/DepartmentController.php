<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::with(['manager', 'employees'])->get();
        return view('department.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create', Department::class)) {
            abort(403);
        }
        $managers = User::where('role_id', User::ROLE_MANAGER)->get();
        return view('department.create', compact('managers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        if (Gate::denies('create', Department::class)) {
            abort(403);
        }
        Department::create($request->validated());
        return redirect()->route('departments.index')->with('success', 'Department created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $department = Department::with(['manager', 'employees'])->findOrFail($id);
        if (Gate::denies('view', $department)) {
            abort(403);
        }
        return view('department.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Gate::denies('update', Department::class)) {
            abort(403);
        }
        $department = Department::findOrFail($id);
        $managers = User::where('role_id', User::ROLE_MANAGER)->get();
        return view('department.edit', compact('department', 'managers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, string $id)
    {
        if (Gate::denies('update', Department::class)) {
            abort(403);
        }
        $department = Department::findOrFail($id);
        $department->update($request->validated());
        return redirect()->route('departments.index')->with('success', 'Department updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Gate::denies('delete', Department::class)) {
            abort(403);
        }
        $department = Department::findOrFail($id);
        if ($department->employees()->count() > 0) {
            return back()->with('error', 'Cannot delete department with employees');
        }
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department deleted successfully');
    }
}
