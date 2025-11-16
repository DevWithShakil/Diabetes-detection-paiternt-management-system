@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Add New Doctor</h2>

    {{-- Validation errors --}}
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

                {{-- Doctor Name --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Doctor Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
                </div>

                {{-- Doctor Email --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Doctor Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                </div>

                {{-- Password --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                </div>

                {{-- Confirm Password --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Re-enter password" required>
                </div>

                {{-- Specialization Dropdown --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Specialization</label>
                    <select name="specialization" class="form-select" required>
                        <option value="">-- Select Specialization --</option>
                        <option value="Endocrinologist">Endocrinologist</option>
                        <option value="Diabetologist">Diabetologist</option>
                        <option value="General Physician">General Physician</option>
                        <option value="Nutritionist / Dietitian">Nutritionist / Dietitian</option>
                        <option value="Diabetes Educator">Diabetes Educator</option>
                        <option value="Cardiologist">Cardiologist</option>
                        <option value="Nephrologist">Nephrologist</option>
                        <option value="Neurologist">Neurologist</option>
                        <option value="Ophthalmologist">Ophthalmologist</option>
                        <option value="Vascular Specialist">Vascular Specialist</option>
                        <option value="Podiatrist (Foot Specialist)">Podiatrist (Foot Specialist)</option>
                    </select>
                </div>

                {{-- Phone Number --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control" placeholder="Enter phone number (optional)">
                </div>
            </div>

            {{-- Buttons --}}
            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('doctors.index') }}" class="btn btn-secondary">← Back</a>
                <button type="submit" class="btn btn-success">Save Doctor</button>
            </div>

        </div>
    </form>
</div>
@endsection
