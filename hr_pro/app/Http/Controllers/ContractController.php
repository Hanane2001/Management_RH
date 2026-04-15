<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreContractRequest;
use App\Http\Requests\UpdateContractRequest;
use App\Models\User;
use App\Models\Contract;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->isManager()) {
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
        $user = auth()->user();
        if (!$user->isManager() && !$user->isAdmin()) {
            abort(403, 'Only managers can create contracts');
        }

        $employees = User::whereHas('role', function($q){
            $q->where('name', 'employ');
        })->get();
        return view('contracts.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractRequest $request)
    {
        if (!auth()->user()->isManager()) {
            abort(403);
        }

        $data = $request->validated();

        if ($request->hasFile('document')) {
            $data['document_path'] = $request->file('document')->store('contracts');
        }

        Contract::create($data);

        return redirect()->route('contracts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        $contract->load('employee');
        $user = auth()->user();
        
        if ($user->isEmployee() && $contract->employee_id !== $user->id) {
            abort(403);
        }
        
        return view('contracts.show', compact('contract'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contract $contract)
    {
        if (!auth()->user()->isManager() && !auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $employees = User::whereHas('role', fn($q) =>
            $q->where('name', 'employ')
        )->get();
        
        return view('contracts.edit', compact('contract', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractRequest $request, Contract $contract)
    {
        if (!auth()->user()->isManager() && !auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $data = $request->validated();
        
        if ($request->hasFile('document')) {
            $data['document_path'] = $request->file('document')->store('contracts');
        }
        
        $contract->update($data);
        
        return redirect()->route('contracts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        if (!auth()->user()->isManager() && !auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $contract->delete();
        
        return redirect()->route('contracts.index');
    }
}
