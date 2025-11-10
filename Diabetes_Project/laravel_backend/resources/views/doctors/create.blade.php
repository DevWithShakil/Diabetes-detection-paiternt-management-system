@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Add New Doctor</h2>

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('doctors.store') }}" method="POST" class="shadow p-4 rounded bg-white">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Doctor Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Doctor Email</label>
            <input type="email" name="email" class="form-control" placeholder="Enter email" required>
        </div>

        <div class="mb-3">
            <label for="specialization" class="form-label">Specialization</label>
            <input type="text" name="specialization" class="form-control" placeholder="e.g. Cardiologist, Skin Specialist" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" name="phone" class="form-control" placeholder="Enter phone number (optional)">
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('doctors.index') }}" class="btn btn-secondary">← Back</a>
            <button type="submit" class="btn btn-success">Save Doctor</button>
        </div>
    </form>
</div>
@endsection
