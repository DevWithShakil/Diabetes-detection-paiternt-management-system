@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center">Welcome, {{ $user->name }} 👋</h2>
    <h5 class="text-center text-success mb-4">Role: {{ ucfirst($user->role) }}</h5>

    {{-- Dashboard Cards --}}
    <div class="row mb-5">
        <div class="col-md-4">
            <div class="card shadow text-center p-4">
                <h4>Total Patients</h4>
                <h2 class="text-primary">{{ $totalPatients }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow text-center p-4">
                <h4>Total Doctors</h4>
                <h2 class="text-success">{{ $totalDoctors }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow text-center p-4">
                <h4>Total Predictions</h4>
                <h2 class="text-danger">{{ $totalPredictions }}</h2>
            </div>
        </div>
    </div>

    {{-- Chart --}}
    <div class="card shadow p-4 mb-5">
        <h4 class="text-center mb-4">Model Accuracy Comparison</h4>
        <canvas id="accuracyChart" height="100"></canvas>
    </div>

    {{-- Patients Table --}}
    <div class="card shadow p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Recent Patients</h4>
            <a href="{{ route('patients.create') }}" class="btn btn-primary btn-sm">+ Add New Patient</a>
        </div>

        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Glucose</th>
                    <th>BMI</th>
                    <th>Prediction (Decision Tree)</th>
                    <th>Report</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse($patients as $index => $patient)
                    @php
                        $result = json_decode($patient->result, true);
                        $prediction = $result['predictions']['Decision Tree'] ?? ($result['status'] ?? 'Pending');
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $patient->name }}</td>
                        <td>{{ $patient->age }}</td>
                        <td>{{ $patient->glucose }}</td>
                        <td>{{ $patient->bmi }}</td>
                        <td>
                            @if($prediction === 'Diabetic')
                                <span class="badge bg-danger">Diabetic</span>
                            @elseif($prediction === 'Non-Diabetic')
                                <span class="badge bg-success">Non-Diabetic</span>
                            @elseif($prediction === 'Pending' || $prediction === 'pending')
                                <span class="badge bg-secondary">Pending</span>
                            @else
                                <span class="badge bg-warning text-dark">{{ $prediction }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('patients.report', $patient->id) }}" class="btn btn-sm btn-outline-primary">
                                Download PDF
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-muted">No patients found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Chart.js Script --}}
<script>
const ctx = document.getElementById('accuracyChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_keys($chartData)) !!},
        datasets: [{
            label: 'Accuracy (%)',
            data: {!! json_encode(array_values($chartData)) !!},
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderWidth: 1
        }]
    },
    options: {
        scales: { y: { beginAtZero: true, max: 100 } },
        plugins: {
            legend: { display: false },
            tooltip: { enabled: true }
        }
    }
});
</script>
@endsection
