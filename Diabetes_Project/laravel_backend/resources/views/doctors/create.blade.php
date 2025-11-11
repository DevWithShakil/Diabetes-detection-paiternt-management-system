@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Add New Doctor</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('doctors.store') }}" method="POST">
        @csrf
        <div class="card shadow-sm p-4">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Doctor Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Doctor Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Re-enter password" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="specialization" class="form-label">Specialization</label>
                    <input type="text" name="specialization" class="form-control" placeholder="e.g. Cardiologist, Skin Specialist">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control" placeholder="Enter phone number (optional)">
                </div>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('doctors.index') }}" class="btn btn-secondary">← Back</a>
                <button type="submit" class="btn btn-success">Save Doctor</button>
            </div>
        </div>
    </form>
</div>
@endsection
