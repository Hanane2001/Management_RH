@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Notification</h1>
    
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
            <form method="POST" action="{{ route('notifications.update', $notification) }}">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label>Recipient</label>
                    <select name="user_id" class="form-control" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $notification->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->first_name }} {{ $user->last_name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $notification->title) }}" required>
                </div>
                
                <div class="mb-3">
                    <label>Message</label>
                    <textarea name="message" class="form-control" rows="5" required>{{ old('message', $notification->message) }}</textarea>
                </div>
                
                <div class="mb-3">
                    <label>Notification Type</label>
                    <select name="type" class="form-control" required>
                        <option value="internal" {{ old('type', $notification->type) == 'internal' ? 'selected' : '' }}>Internal (Database only)</option>
                        <option value="email" {{ old('type', $notification->type) == 'email' ? 'selected' : '' }}>Email</option>
                        <option value="sms" {{ old('type', $notification->type) == 'sms' ? 'selected' : '' }}>SMS</option>
                    </select>
                </div>
                
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Update Notification</button>
                    <a href="{{ route('notifications.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection