@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Add New Doctor</h3>

    <form method="POST" action="{{ route('doctors.store') }}">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="mb-3">
            <label>Specialization</label>
            <input type="text" class="form-control" name="specialization" required>
        </div>
        <div class="mb-3">
            <label>Phone (optional)</label>
            <input type="text" class="form-control" name="phone">
        </div>
        <button type="submit" class="btn btn-success">Save Doctor</button>
    </form>
</div>
@endsection
