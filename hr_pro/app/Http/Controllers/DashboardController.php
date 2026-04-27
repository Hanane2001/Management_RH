<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contract;
use App\Models\Leave;
use App\Models\LeaveBalance;
use App\Models\Evaluation;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isManager()) {
            return $this->managerDashboard();
        } else {
            return $this->employeeDashboard();
        }
    }
    
    private function adminDashboard()
    {
        $stats = [
            'total_employees' => User::where('role_id', User::ROLE_EMPLOYEE)->count(),
            'pending_approvals' => User::where('role_id', User::ROLE_USER)->count(),
            'total_contracts' => Contract::count(),
            'active_contracts' => Contract::whereNull('end_date')->orWhere('end_date', '>', now())->count(),
            'pending_leaves' => Leave::where('status', 'pending')->count(),
            'approved_leaves' => Leave::where('status', 'approved')->count(),
            'total_leaves' => Leave::count(),
            'expiring_contracts' => Contract::where('end_date', '<=', now()->addMonths(1))->where('end_date', '>', now())->count(),
            'total_evaluations' => Evaluation::count(),
            'average_score' => Evaluation::avg('overall_score'),
        ];
        
        $recent_employees = User::with('role')->where('role_id', User::ROLE_EMPLOYEE)->latest()->take(5)->get();
        $pending_approvals = User::with('role')->where('role_id', User::ROLE_USER)->latest()->take(5)->get();
        $pending_leaves = Leave::with('employee')->where('status', 'pending')->latest()->take(5)->get();
        $recent_contracts = Contract::with('employee')->latest()->take(5)->get();
        
        return view('dashboard.admin', compact('stats', 'recent_employees', 'pending_approvals', 'pending_leaves', 'recent_contracts'));
    }
    
    private function managerDashboard()
    {
        $employeeIds = User::where('department_id', auth()->user()->department_id)->where('role_id', User::ROLE_EMPLOYEE)->pluck('id');
        $stats = [
            'total_employees' => $employeeIds->count(),
            'total_contracts' => Contract::whereIn('employee_id', $employeeIds)->count(),
            'active_contracts' => Contract::whereIn('employee_id', $employeeIds)->whereNull('end_date')->count(),
            'pending_leaves' => Leave::whereIn('employee_id', $employeeIds)->where('status', 'pending')->count(),
            'approved_leaves' => Leave::whereIn('employee_id', $employeeIds)->where('status', 'approved')->count(),
            'total_evaluations' => Evaluation::whereIn('employee_id', $employeeIds)->count(),
            'average_score' => Evaluation::whereIn('employee_id', $employeeIds)->avg('overall_score'),
        ];
        
        $pending_leaves = Leave::with('employee')->whereIn('employee_id', $employeeIds)->where('status', 'pending')->latest()->take(5)->get();
        $recent_employees = User::whereIn('id', $employeeIds)->latest()->take(5)->get();
        $recent_contracts = Contract::with('employee')->whereIn('employee_id', $employeeIds)->latest()->take(5)->get();
        return view('dashboard.manager', compact('stats', 'pending_leaves', 'recent_employees', 'recent_contracts'));
    }
    
    private function employeeDashboard()
    {
        $user = auth()->user();
        
        $currentBalance = LeaveBalance::where('employee_id', $user->id)->where('year', date('Y'))->first();
            
        $stats = [
            'my_contracts' => Contract::where('employee_id', $user->id)->count(),
            'active_contract' => Contract::where('employee_id', $user->id)->whereNull('end_date')->first(),
            'my_leaves' => Leave::where('employee_id', $user->id)->count(),
            'pending_leaves' => Leave::where('employee_id', $user->id)->where('status', 'pending')->count(),
            'approved_leaves' => Leave::where('employee_id', $user->id)->where('status', 'approved')->count(),
            'leave_balance' => $currentBalance ? $currentBalance->remaining_days : 0,
            'total_leave_days' => $currentBalance ? $currentBalance->total_days : 0,
            'used_leave_days' => $currentBalance ? $currentBalance->used_days : 0,
            'my_evaluations' => Evaluation::where('employee_id', $user->id)->count(),
            'my_average_score' => Evaluation::where('employee_id', $user->id)->avg('overall_score'),
        ];
        
        $my_leaves = Leave::where('employee_id', $user->id)->latest()->take(5)->get();
        $my_contracts = Contract::where('employee_id', $user->id)->latest()->get();
        return view('dashboard.employee', compact('stats', 'my_leaves', 'my_contracts'));
    }
}