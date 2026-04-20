@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Send Notification</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('notifications.store') }}">
                @csrf
                
                <div class="mb-3">
                    <label>Recipient *</label>
                    <select name="user_id" class="form-control" required>
                        <option value="">Select User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->first_name }} {{ $user->last_name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label>Title *</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>
                
                <div class="mb-3">
                    <label>Message *</label>
                    <textarea name="message" class="form-control" rows="5" required>{{ old('message') }}</textarea>
                </div>
                
                <div class="mb-3">
                    <label>Notification Type *</label>
                    <select name="type" class="form-control" required>
                        <option value="internal" {{ old('type') == 'internal' ? 'selected' : '' }}>Internal (Database only)</option>
                        <option value="email" {{ old('type') == 'email' ? 'selected' : '' }}>Email</option>
                        <option value="sms" {{ old('type') == 'sms' ? 'selected' : '' }}>SMS</option>
                    </select>
                </div>
                
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Send Notification</button>
                    <a href="{{ route('notifications.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection