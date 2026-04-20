<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         $user = auth()->user();
        $filter = $request->get('filter', 'all');
        
        if ($user->isAdmin()) {
            $notifications = Notification::with('user')->latest();
        } elseif ($user->isManager()) {
            $employeeIds = User::where('department_id', $user->department_id)->pluck('id');
            $notifications = Notification::with('user')->whereIn('user_id', $employeeIds)->orWhere('user_id', $user->id)->latest();
        } else {
            $notifications = Notification::with('user')->where('user_id', $user->id)->latest();
        }
        
        if ($filter === 'unread') {
            $notifications = $notifications->where('is_read', false);
        } elseif ($filter === 'read') {
            $notifications = $notifications->where('is_read', true);
        }
        
        $notifications = $notifications->paginate(20);
        
        $stats = [
            'total' => Notification::where('user_id', $user->id)->count(),
            'unread' => Notification::where('user_id', $user->id)->where('is_read', false)->count(),
            'read' => Notification::where('user_id', $user->id)->where('is_read', true)->count(),
            'email_count' => Notification::where('user_id', $user->id)->where('type', 'email')->count(),
            'sms_count' => Notification::where('user_id', $user->id)->where('type', 'sms')->count(),
            'internal_count' => Notification::where('user_id', $user->id)->where('type', 'internal')->count(),
        ];
        
        return view('notifications.index', compact('notifications', 'stats', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create', Notification::class)) {
            abort(403);
        }
        
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $users = User::all();
        } elseif ($user->isManager()) {
            $users = User::where('department_id', $user->department_id)->orWhere('id', $user->id)->get();
        } else {
            $users = collect([$user]);
        }
        
        return view('notifications.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNotificationRequest $request)
    {
        if (Gate::denies('create', Notification::class)) {
            abort(403);
        }
        
        $data = $request->validated();
        $data['sent_at'] = Carbon::now();
        $notification = Notification::create($data);

        if ($request->type === 'email') {
            $this->sendEmailNotification($notification);
        }
        if ($request->type === 'sms') {
            // $this->sendSmsNotification($notification);
        }
        
        return redirect()->route('notifications.index')->with('success', 'Notification sent successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        if (Gate::denies('view', $notification)) {
            abort(403);
        }

        if (!$notification->is_read) {
            $notification->markAsRead();
        }
        
        $notification->load('user');
        return view('notifications.show', compact('notification'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notification $notification)
    {
        if (Gate::denies('update', $notification)) {
            abort(403);
        }
        
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $users = User::all();
        } elseif ($user->isManager()) {
            $users = User::where('department_id', $user->department_id)->orWhere('id', $user->id)->get();
        } else {
            $users = collect([$user]);
        }
        
        return view('notifications.edit', compact('notification', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNotificationRequest $request, Notification $notification)
    {
        if (Gate::denies('update', $notification)) {
            abort(403);
        }
        
        $notification->update($request->validated());
        
        return redirect()->route('notifications.index')->with('success', 'Notification updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        if (Gate::denies('delete', $notification)) {
            abort(403);
        }
        
        $notification->delete();
        
        return redirect()->route('notifications.index')->with('success', 'Notification deleted successfully');
    }

    public function markAsRead(Notification $notification)
    {
        if (Gate::denies('view', $notification)) {
            abort(403);
        }
        
        $notification->markAsRead();
        
        return redirect()->route('notifications.index')->with('success', 'Notification marked as read');
    }

    public function markAllAsRead()
    {
        $user = auth()->user();
        Notification::where('user_id', $user->id)->where('is_read', false)->update(['is_read' => true]);
        return redirect()->route('notifications.index')->with('success', 'All notifications marked as read');
    }

    public function deleteAll()
    {
        $user = auth()->user();
        Notification::where('user_id', $user->id)->delete();
        return redirect()->route('notifications.index')->with('success', 'All notifications deleted');
    }

    public function getUnreadCount()
    {
        $user = auth()->user();
        $count = Notification::where('user_id', $user->id)->where('is_read', false)->count();
        return response()->json(['count' => $count]);
    }

    public function getRecent()
    {
        $user = auth()->user();
        $notifications = Notification::where('user_id', $user->id)->latest()->take(10)->get();
        $unreadCount = Notification::where('user_id', $user->id)->where('is_read', false)->count();
        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    public function sendBulk(Request $request)
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isManager()) {
            abort(403);
        }
        
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:email,sms,internal'
        ]);
        
        $sent = 0;
        
        foreach ($request->user_ids as $userId) {
            $notification = Notification::create([
                'user_id' => $userId,
                'title' => $request->title,
                'message' => $request->message,
                'type' => $request->type,
                'sent_at' => Carbon::now()
            ]);
            
            if ($request->type === 'email') {
                $this->sendEmailNotification($notification);
            }
            
            $sent++;
        }
        
        return redirect()->route('notifications.index')->with('success', "$sent notifications sent successfully");
    }

    private function sendEmailNotification(Notification $notification)
    {
        try {
            Mail::raw($notification->message, function ($message) use ($notification) {
                $message->to($notification->user->email)->subject($notification->title);
            });
        } catch (\Exception $e) {
            \Log::error("Email notification failed: " . $e->getMessage());
        }
    }

    public static function leaveRequestNotification($leave)
    {
        $manager = User::where('department_id', $leave->employee->department_id)->where('role_id', User::ROLE_MANAGER)->first();
        
        if ($manager) {
            Notification::create([
                'user_id' => $manager->id,
                'title' => 'New Leave Request',
                'message' => $leave->employee->first_name . ' ' . $leave->employee->last_name . 
                            ' has requested ' . $leave->type . ' leave from ' . 
                            $leave->start_date->format('d/m/Y') . ' to ' . $leave->end_date->format('d/m/Y'),
                'type' => 'internal',
                'sent_at' => Carbon::now()
            ]);
        }
    }

    public static function leaveApprovalNotification($leave)
    {
        Notification::create([
            'user_id' => $leave->employee_id,
            'title' => 'Leave Request ' . ucfirst($leave->status),
            'message' => 'Your leave request from ' . $leave->start_date->format('d/m/Y') . 
                        ' to ' . $leave->end_date->format('d/m/Y') . ' has been ' . $leave->status,
            'type' => 'internal',
            'sent_at' => Carbon::now()
        ]);
    }

    public static function contractExpirationNotification($contract)
    {
        Notification::create([
            'user_id' => $contract->employee_id,
            'title' => 'Contract Expiration Alert',
            'message' => 'Your contract will expire on ' . $contract->end_date->format('d/m/Y') . 
                        '. Please contact HR for renewal.',
            'type' => 'internal',
            'sent_at' => Carbon::now()
        ]);
    }

    public static function payrollGeneratedNotification($payroll)
    {
        Notification::create([
            'user_id' => $payroll->employee_id,
            'title' => 'Payroll Generated',
            'message' => 'Your payroll for ' . $payroll->getMonthName() . ' ' . $payroll->year . 
                        ' has been generated. Net amount: ' . number_format($payroll->net_pay, 2) . ' DH',
            'type' => 'internal',
            'sent_at' => Carbon::now()
        ]);
    }
}
