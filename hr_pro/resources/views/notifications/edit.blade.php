@extends('layouts.app')

@section('title', 'Edit Notification')

@section('content')
<style>
    .form-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
        max-width: 800px;
        margin: 0 auto;
    }
    
    .form-header {
        padding: 20px 24px;
        border-bottom: 1px solid #E5E7EB;
        background: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .form-header h3 {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 1.25rem;
        color: #1F2937;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .form-header h3 i {
        color: #1D4ED8;
    }
    
    .btn-back {
        background: #F3F4F6;
        color: #374151;
        padding: 8px 16px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-back:hover {
        background: #E5E7EB;
        color: #1F2937;
    }
    
    .form-body {
        padding: 24px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-label {
        display: block;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 6px;
    }
    
    .form-label span {
        color: #EF4444;
    }
    
    .form-input, .form-select, .form-textarea {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        font-family: 'Roboto', sans-serif;
        font-size: 0.9rem;
        transition: all 0.2s;
        outline: none;
        background: white;
    }
    
    .form-input:focus, .form-select:focus, .form-textarea:focus {
        border-color: #1D4ED8;
        box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.1);
    }
    
    .form-check {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .form-check-input {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
    
    .form-check-label {
        font-family: 'Roboto', sans-serif;
        font-size: 0.85rem;
        color: #374151;
        cursor: pointer;
    }
    
    .btn-submit {
        background: #1D4ED8;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .btn-submit:hover {
        background: #1E3A8A;
        transform: translateY(-1px);
    }
    
    @media (max-width: 768px) {
        .form-header {
            padding: 16px 20px;
        }
        
        .form-body {
            padding: 20px;
        }
    }
</style>

<div class="container-fluid">
    <div class="form-card">
        <div class="form-header">
            <h3>
                <i class="fas fa-edit"></i> Edit Notification
            </h3>
            <a href="{{ route('notifications.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <div class="form-body">
            <form method="POST" action="{{ route('notifications.update', $notification) }}">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label class="form-label">Recipient <span>*</span></label>
                    <select class="form-select @error('user_id') is-invalid @enderror" name="user_id" required>
                        <option value="">Select user...</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $notification->user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->getFullName() }} ({{ $user->email }}) - {{ ucfirst($user->role->name ?? 'N/A') }}
                        </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Title <span>*</span></label>
                    <input type="text" class="form-input @error('title') is-invalid @enderror" 
                           name="title" value="{{ old('title', $notification->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Message <span>*</span></label>
                    <textarea class="form-textarea @error('message') is-invalid @enderror" 
                              name="message" rows="5" required>{{ old('message', $notification->message) }}</textarea>
                    @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Notification Type <span>*</span></label>
                    <select class="form-select @error('type') is-invalid @enderror" name="type" required>
                        <option value="internal" {{ old('type', $notification->type) == 'internal' ? 'selected' : '' }}>Internal (System)</option>
                        <option value="email" {{ old('type', $notification->type) == 'email' ? 'selected' : '' }}>Email</option>
                        <option value="sms" {{ old('type', $notification->type) == 'sms' ? 'selected' : '' }}>SMS</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_read" name="is_read" value="1" 
                               {{ old('is_read', $notification->is_read) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_read">
                            <i class="fas fa-check-circle"></i> Mark as Read
                        </label>
                    </div>
                </div>
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Update Notification
                </button>
            </form>
        </div>
    </div>
</div>
@endsection