<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Services\AuditLogService;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = auth()->user();
        $user->load(['role', 'department']);
        
        $stats = [
            'total_leaves' => $user->leaves()->count(),
            'pending_leaves' => $user->leaves()->where('status', 'pending')->count(),
            'approved_leaves' => $user->leaves()->where('status', 'approved')->count(),
            'contracts_count' => $user->contracts()->count(),
            'documents_count' => $user->documents()->count(),
            'evaluations_count' => $user->evaluations()->count(),
        ];
        
        if ($user->isEmployee()) {
            $currentBalance = $user->getCurrentLeaveBalance();
            $stats['leave_balance'] = $currentBalance ? $currentBalance->remaining_days : 0;
            $stats['total_leave_days'] = $currentBalance ? $currentBalance->total_days : 0;
            $stats['used_leave_days'] = $currentBalance ? $currentBalance->used_days : 0;
        }
        
        return view('profile.show', compact('user', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request  $request)
    {
        $user = auth()->user();
        
        $oldValues = $user->getOriginal();
        
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
        ]);
        
        AuditLogService::logUpdate('User', $user, $oldValues);
        
        return redirect()->route('profile.show')->with('success', 'Profile updated successfully');
    }

    public function showChangePassword()
    {
        return view('profile.change-password');
    }

    public function changePassword(Request $request)
    {
        $user = auth()->user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect');
        }
        
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        
        AuditLogService::logUpdate('User', $user, ['password' => '[HIDDEN]']);
        
        return redirect()->route('profile.show')->with('success', 'Password changed successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
