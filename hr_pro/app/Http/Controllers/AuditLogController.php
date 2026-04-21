<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class AuditLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only administrators can view audit logs');
        }
        
        $query = AuditLog::with('user');
        
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }
        
        if ($request->filled('entity_type')) {
            $query->where('entity_type', $request->entity_type);
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('entity_type', 'like', "%{$search}%")->orWhere('action', 'like', "%{$search}%")->orWhere('entity_id', 'like', "%{$search}%");
            });
        }
        
        $logs = $query->latest('created_at')->paginate(50);

        $stats = [
            'total' => AuditLog::count(),
            'today' => AuditLog::whereDate('created_at', Carbon::today())->count(),
            'this_week' => AuditLog::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count(),
            'this_month' => AuditLog::whereMonth('created_at', Carbon::now()->month)->count(),
            'by_action' => AuditLog::selectRaw('action, COUNT(*) as count')->groupBy('action')->get(),
            'by_entity' => AuditLog::selectRaw('entity_type, COUNT(*) as count')->groupBy('entity_type')->get(),
            'top_users' => AuditLog::selectRaw('user_id, COUNT(*) as count')->with('user')->groupBy('user_id')->orderBy('count', 'desc')->limit(5)->get()
        ];
        
        $users = User::all();
        $actions = AuditLog::distinct()->pluck('action');
        $entityTypes = AuditLog::distinct()->pluck('entity_type');
        
        return view('audit_logs.index', compact('logs', 'stats', 'users', 'actions', 'entityTypes'));
    }

    public function forEntity($entityType, $entityId)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $logs = AuditLog::with('user')->where('entity_type', $entityType)->where('entity_id', $entityId)->latest('created_at')->paginate(50);
        return view('audit_logs.entity', compact('logs', 'entityType', 'entityId'));
    }

    public function forUser($userId)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $targetUser = User::findOrFail($userId);
        $logs = AuditLog::with('user')->where('user_id', $userId)->latest('created_at')->paginate(50);
        return view('audit_logs.user', compact('logs', 'targetUser'));
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
    public function show(AuditLog $auditLog)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $auditLog->load('user');
        return view('audit_logs.show', compact('auditLog'));
    }

    public function export(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $query = AuditLog::with('user');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }
        if ($request->filled('entity_type')) {
            $query->where('entity_type', $request->entity_type);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $logs = $query->latest('created_at')->get();
        
        $filename = "audit_logs_" . Carbon::now()->format('Y-m-d_H-i-s') . ".csv";
        $handle = fopen('php://temp', 'w');
        
        fputcsv($handle, ['ID', 'User', 'Email', 'Action', 'Entity Type', 'Entity ID', 'Changes', 'IP Address', 'Created At']);
        
        foreach ($logs as $log) {
            fputcsv($handle, [
                $log->id,
                $log->user ? $log->user->first_name . ' ' . $log->user->last_name : 'System',
                $log->user ? $log->user->email : 'system@hrpro.com',
                $log->action,
                $log->entity_type,
                $log->entity_id,
                $log->getChangesSummary(),
                $log->ip_address ?? 'N/A',
                $log->created_at->format('d/m/Y H:i:s')
            ]);
        }
        
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);
        
        return response($csv, 200)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename=\"$filename\"");
    }

    public function clean(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $request->validate([
            'days' => 'required|integer|min:1|max:365'
        ]);
        
        $date = Carbon::now()->subDays($request->days);
        $deleted = AuditLog::where('created_at', '<', $date)->delete();
        
        return redirect()->route('audit-logs.index')
            ->with('success', "$deleted audit logs older than {$request->days} days have been deleted");
    }

    public function dashboard()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $stats = [
            'total' => AuditLog::count(),
            'today' => AuditLog::whereDate('created_at', Carbon::today())->count(),
            'last_7_days' => AuditLog::whereDate('created_at', '>=', Carbon::now()->subDays(7))->count(),
            'last_30_days' => AuditLog::whereDate('created_at', '>=', Carbon::now()->subDays(30))->count(),
            'by_action' => AuditLog::selectRaw('action, COUNT(*) as count')->groupBy('action')->get(),
            'by_hour' => AuditLog::selectRaw('HOUR(created_at) as hour, COUNT(*) as count')->whereDate('created_at', Carbon::today())->groupBy('hour')->orderBy('hour')->get(),
            'recent_activities' => AuditLog::with('user')->latest('created_at')->limit(20)->get()
        ];
        
        return view('audit_logs.dashboard', compact('stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AuditLog $auditLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AuditLog $auditLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AuditLog $auditLog)
    {
        //
    }
}
