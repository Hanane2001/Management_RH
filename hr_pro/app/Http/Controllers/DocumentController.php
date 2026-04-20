<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $documents = Document::with('employee')->latest()->paginate(10);
        } elseif ($user->isManager()) {
            $employeeIds = User::where('department_id', $user->department_id)->where('role_id', User::ROLE_EMPLOYEE)->pluck('id');
            $documents = Document::with('employee')->whereIn('employee_id', $employeeIds)->latest()->paginate(10);
        } else {
            $documents = Document::with('employee')->where('employee_id', $user->id)->latest()->paginate(10);
        }
        
        return view('documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create', Document::class)) {
            abort(403);
        }
        
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $employees = User::where('role_id', User::ROLE_EMPLOYEE)->get();
        } elseif ($user->isManager()) {
            $employees = User::where('department_id', $user->department_id)->where('role_id', User::ROLE_EMPLOYEE)->get();
        } else {
            $employees = collect([$user]);
        }
        
        return view('documents.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentRequest  $request)
    {
        if (Gate::denies('create', Document::class)) {
            abort(403);
        }
        
        $file = $request->file('document');
        $originalName = $file->getClientOriginalName();
        $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $originalName);

        $path = $file->storeAs('documents', $fileName, 'public');
        
        Document::create([
            'employee_id' => $request->employee_id,
            'type' => $request->type,
            'file_name' => $originalName,
            'file_path' => $path,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType()
        ]);
        
        return redirect()->route('documents.index')->with('success', 'Document uploaded successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        if (Gate::denies('view', $document)) {
            abort(403);
        }
        
        $document->load('employee');
        return view('documents.show', compact('document'));
    }

    public function download(Document $document)
    {
        if (Gate::denies('view', $document)) {
            abort(403);
        }
        
        $filePath = storage_path('app/public/' . $document->file_path);
        
        if (!file_exists($filePath)) {
            return back()->with('error', 'File not found');
        }
        
        return response()->download($filePath, $document->file_name);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        if (Gate::denies('update', $document)) {
            abort(403);
        }
        
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $employees = User::where('role_id', User::ROLE_EMPLOYEE)->get();
        } else {
            $employees = User::where('department_id', $user->department_id)->where('role_id', User::ROLE_EMPLOYEE)->get();
        }
        
        return view('documents.edit', compact('document', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocumentRequest $request, Document $document)
    {
        if (Gate::denies('update', $document)) {
            abort(403);
        }
        
        $data = $request->validated();
        
        if ($request->hasFile('document')) {
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }
            
            $file = $request->file('document');
            $originalName = $file->getClientOriginalName();
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $originalName);
            $path = $file->storeAs('documents', $fileName, 'public');
            
            $data['file_name'] = $originalName;
            $data['file_path'] = $path;
            $data['file_size'] = $file->getSize();
            $data['mime_type'] = $file->getMimeType();
        }
        
        $document->update($data);
        
        return redirect()->route('documents.index')
            ->with('success', 'Document updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        if (Gate::denies('delete', $document)) {
            abort(403);
        }
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        
        $document->delete();
        
        return redirect()->route('documents.index')->with('success', 'Document deleted successfully');
    }

    public function employeeDocuments($employeeId)
    {
        $employee = User::findOrFail($employeeId);
        
        if (Gate::denies('view', $employee)) {
            abort(403);
        }
        
        $documents = Document::where('employee_id', $employeeId)->latest()->paginate(10);
        return view('documents.employee', compact('employee', 'documents'));
    }
}
