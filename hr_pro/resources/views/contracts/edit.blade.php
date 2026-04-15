@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Contract</h1>

    <form method="POST" action="{{ route('contracts.update', $contract->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="text" name="type" value="{{ $contract->type }}">

        <input type="number" name="base_salary" value="{{ $contract->base_salary }}">

        <input type="number" name="bonus" value="{{ $contract->bonus }}">

        <input type="text" name="position" value="{{ $contract->position }}">

        <input type="date" name="start_date" value="{{ $contract->start_date }}">

        <input type="date" name="end_date" value="{{ $contract->end_date }}">

        <input type="file" name="document">

        <button type="submit">Update</button>
    </form>
</div>
@endsection