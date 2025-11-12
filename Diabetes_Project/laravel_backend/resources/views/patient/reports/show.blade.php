@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">🩺 Diabetes Report of {{ $patient->name }}</h4>
        </div>
        <div class="card-body">
            <h5>Basic Details</h5>
            <table class="table table-bordered">
                <tr><th>Age</th><td>{{ $patient->age }}</td></tr>
                <tr><th>Glucose</th><td>{{ $patient->glucose }}</td></tr>
                <tr><th>Blood Pressure</th><td>{{ $patient->blood_pressure }}</td></tr>
                <tr><th>Skin Thickness</th><td>{{ $patient->skin_thickness }}</td></tr>
                <tr><th>Insulin</th><td>{{ $patient->insulin }}</td></tr>
                <tr><th>BMI</th><td>{{ $patient->bmi }}</td></tr>
                <tr><th>Diabetes Pedigree</th><td>{{ $patient->diabetes_pedigree }}</td></tr>
            </table>

            <h5 class="mt-4 text-primary">Prediction Results</h5>
            @if(isset($result['predictions']))
                <ul class="list-group">
                    @foreach($result['predictions'] as $model => $prediction)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $model }}
                            <span class="badge bg-{{ $prediction === 'Diabetic' ? 'danger' : 'success' }}">
                                {{ $prediction }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">No prediction data available.</p>
            @endif

            <div class="mt-4">
                <a href="{{ route('patient.report.download', $patient->id) }}" class="btn btn-success">
                    <i class="bi bi-download"></i> Download Report (PDF)
                </a>
                <a href="{{ route('patient.dashboard') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
