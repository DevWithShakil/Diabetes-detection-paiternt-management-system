@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Edit Doctor</h2>

    <form action="{{ route('doctors.update', $doctor->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $doctor->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ $doctor->email }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Specialization</label>
            <input type="text" name="specialization" value="{{ $doctor->specialization }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" value="{{ $doctor->phone }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update Doctor</button>
        <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
