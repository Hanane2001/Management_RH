<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evaluation;
use App\Models\User;
use App\Http\Requests\StoreEvaluationRequest;
use App\Http\Requests\UpdateEvaluationRequest;
use Illuminate\Support\Facades\Gate;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $evaluations = Evaluation::with(['employee', 'evaluator'])->latest()->paginate(10);
        } elseif ($user->isManager()) {
            $employeeIds = User::where('department_id', $user->department_id)->where('role_id', User::ROLE_EMPLOYEE)->pluck('id');
            $evaluations = Evaluation::with(['employee', 'evaluator'])->whereIn('employee_id', $employeeIds)->latest()->paginate(10);
        } else {
            $evaluations = Evaluation::with('evaluator')->where('employee_id', $user->id)->latest()->paginate(10);
        }
        
        return view('evaluations.index', compact('evaluations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create', Evaluation::class)) {
            abort(403, 'Only manager can create Evaluation.');
        }
        $user = auth()->user();
        
        $employees = User::where('role_id', User::ROLE_EMPLOYEE)->get();
        return view('evaluations.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEvaluationRequest  $request)
    {
        if (Gate::denies('create', Evaluation::class)) {
            abort(403);
        }
        Evaluation::create([
            'employee_id' => $request->employee_id,
            'evaluator_id' => auth()->id(),
            'evaluation_date' => $request->evaluation_date,
            'period' => $request->period,
            'overall_score' => $request->overall_score,
            'comments' => $request->comments
        ]);
        return redirect()->route('evaluations.index')->with('success', 'Evaluation created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Evaluation $evaluation)
    {
        if (Gate::denies('view', $evaluation)) {
            abort(403);
        }
        
        $evaluation->load(['employee', 'evaluator']);
        return view('evaluations.show', compact('evaluation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evaluation $evaluation)
    {
        if (Gate::denies('update', $evaluation)) {
            abort(403, 'Only manager can edit Evaluation.');
        }
        
        $user = auth()->user();
        $employees = User::where('department_id', $user->department_id)->where('role_id', User::ROLE_EMPLOYEE)->get();
        
        return view('evaluations.edit', compact('evaluation', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEvaluationRequest  $request, Evaluation $evaluation)
    {
        if (Gate::denies('update', $evaluation)) {
            abort(403);
        }
        $evaluation->update($request->validated());
        return redirect()->route('evaluations.index')->with('success', 'Evaluation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evaluation $evaluation)
    {
        if (Gate::denies('delete', $evaluation)) {
            abort(403);
        }
        
        $evaluation->delete();
        return redirect()->route('evaluations.index')->with('success', 'Evaluation deleted successfully');
    }

    public function statistics()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $stats = [
                'total_evaluations' => Evaluation::count(),
                'average_score' => Evaluation::avg('overall_score'),
                'excellent_count' => Evaluation::where('overall_score', '>=', 90)->count(),
                'good_count' => Evaluation::whereBetween('overall_score', [75, 89])->count(),
                'satisfactory_count' => Evaluation::whereBetween('overall_score', [60, 74])->count(),
                'poor_count' => Evaluation::where('overall_score', '<', 60)->count(),
                'evaluations_by_month' => Evaluation::selectRaw('DATE_FORMAT(evaluation_date, "%Y-%m") as month, COUNT(*) as count')->groupBy('month')->orderBy('month', 'desc')->limit(12)->get(),
                'top_employees' => Evaluation::with('employee')->selectRaw('employee_id, AVG(overall_score) as avg_score')->groupBy('employee_id')->orderBy('avg_score', 'desc')->limit(10)->get()
            ];
        } elseif ($user->isManager()) {
            $employeeIds = User::where('department_id', $user->department_id)->where('role_id', User::ROLE_EMPLOYEE)->pluck('id');
                
            $stats = [
                'total_evaluations' => Evaluation::whereIn('employee_id', $employeeIds)->count(),
                'average_score' => Evaluation::whereIn('employee_id', $employeeIds)->avg('overall_score'),
                'excellent_count' => Evaluation::whereIn('employee_id', $employeeIds)->where('overall_score', '>=', 90)->count(),
                'good_count' => Evaluation::whereIn('employee_id', $employeeIds)->whereBetween('overall_score', [75, 89])->count(),
                'satisfactory_count' => Evaluation::whereIn('employee_id', $employeeIds)->whereBetween('overall_score', [60, 74])->count(),
                'poor_count' => Evaluation::whereIn('employee_id', $employeeIds)->where('overall_score', '<', 60)->count(),
            ];
        } else {
            $stats = [
                'my_evaluations' => Evaluation::where('employee_id', $user->id)->count(),
                'my_average_score' => Evaluation::where('employee_id', $user->id)->avg('overall_score'),
                'my_best_score' => Evaluation::where('employee_id', $user->id)->max('overall_score'),
                'my_last_evaluation' => Evaluation::where('employee_id', $user->id)->latest()->first()
            ];
        }
        
        return view('evaluations.statistics', compact('stats'));
    }
}
