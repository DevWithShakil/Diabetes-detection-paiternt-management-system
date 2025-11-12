@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Add New Patient</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('patients.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">Patient Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" name="age" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3">
                <label for="glucose" class="form-label">Glucose</label>
                <input type="number" name="glucose" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label for="blood_pressure" class="form-label">Blood Pressure</label>
                <input type="number" name="blood_pressure" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label for="skin_thickness" class="form-label">Skin Thickness</label>
                <input type="number" name="skin_thickness" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label for="insulin" class="form-label">Insulin</label>
                <input type="number" name="insulin" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label for="bmi" class="form-label">BMI</label>
                <input type="number" step="0.01" name="bmi" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label for="diabetes_pedigree" class="form-label">Diabetes Pedigree Function</label>
                <input type="number" step="0.01" name="diabetes_pedigree" class="form-control">
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Save Patient</button>
    </form>
</div>
@endsection
