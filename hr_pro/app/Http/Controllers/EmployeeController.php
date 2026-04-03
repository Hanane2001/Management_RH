<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;


class EmployeeController extends Controller
{
    public function checkEmployee($employee){
        if(!$employee->role || $employee->role->name !== 'employ'){
            abort(404);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = User::with('role')->where('role_id', User::ROLE_EMPLOYEE)->latest()->paginate(10);
        return view('employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employee.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        $employee = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => User::ROLE_EMPLOYEE,
            'department_id' => $request->department_id,
            'phone' => $request->phone,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
            'id_number' => $request->id_number,
            'social_security_number' => $request->social_security_number,
            'is_active' => true,
        ]);
        return redirect()->route('employees.index')->with('success', 'Employee added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = User::with('role')->findOrFail($id);
        $this->checkEmployee($employee);
        return view('employee.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(string $id)
    {
        $employee = User::with('role')->findOrFail($id);
        $this->checkEmployee($employee);
        return view('employee.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, string $id)
    {
        $employee = User::with('role')->findOrFail($id);
        $this->checkEmployee($employee);
        $employee->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'department_id' => $request->department_id,
            'phone' => $request->phone,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
            'id_number' => $request->id_number,
            'social_security_number' => $request->social_security_number,
        ]);
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = User::with('role')->findOrFail($id);
        $this->checkEmployee($employee);
        if($employee->id == auth()->id()){
            return back()->with('error', 'You cannot delete yourself');
        }
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully');
    }
}
