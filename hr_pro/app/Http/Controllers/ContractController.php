<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreContractRequest;
use App\Http\Requests\UpdateContractRequest;
use App\Models\User;
use App\Models\Contract;
use Illuminate\Support\Facades\Gate;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if (Gate::allows('isAdmin') || Gate::allows('isManager')) {
            $contracts = Contract::with('employee')->get();
        } else {
            $contracts = Contract::with('employee')->where('employee_id', $user->id)->get();
        }

        return view('contracts.index', compact('contracts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create', Contract::class)) {
            abort(403, 'Only managers can create contracts');
        }
        $employees = User::where('role_id', User::ROLE_EMPLOYEE)->get();
        return view('contracts.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractRequest $request)
    {
        if(Gate::denies('create', Contract::class)){
            abort(403);
        }

        $data = $request->validated();

        if ($request->hasFile('document')) {
            $data['document_path'] = $request->file('document')->store('contracts', 'public');
        }

        Contract::create($data);

        return redirect()->route('contracts.index')->with('success', 'Contract created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        if (Gate::denies('view', $contract)) {
            abort(403);
        }
        
        return view('contracts.show', compact('contract'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contract $contract)
    {
        if (Gate::denies('update', $contract)) {
            abort(403);
        }
        $employees = User::where('role_id', User::ROLE_EMPLOYEE)->get();
        
        return view('contracts.edit', compact('contract', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractRequest $request, Contract $contract)
    {
        if (Gate::denies('update', $contract)) {
            abort(403);
        }
        
        $data = $request->validated();
        
        if ($request->hasFile('document')) {
            $data['document_path'] = $request->file('document')->store('contracts', 'public');
        }
        
        $contract->update($data);
        
        return redirect()->route('contracts.index')->with('success', 'Contract updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        if (Gate::denies('delete', $contract)) {
            abort(403);
        }
        
        $contract->delete();
        
        return redirect()->route('contracts.index')->with('success', 'Contract deleted successfully');
    }
}
