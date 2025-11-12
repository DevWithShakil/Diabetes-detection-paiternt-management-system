@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- 🔹 Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">All Patients</h2>
        {{-- 🩺 Add Patient Button --}}
        <a href="{{ route('patients.create') }}" class="btn btn-primary">
            ➕ Add New Patient
        </a>
    </div>

    {{-- 🔹 Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- 🔹 Patients Table --}}
    @if($patients->isEmpty())
        <div class="alert alert-info">No patients found. Click “Add New Patient” to create one.</div>
    @else
        <div class="table-responsive shadow-sm">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Patient Name</th>
                        <th>Email</th>
                        <th>Age</th>
                        <th>Glucose</th>
                        <th>Blood Pressure</th>
                        <th>BMI</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($patients as $key => $patient)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $patient->name }}</td>
                            <td>{{ $patient->user->email ?? 'N/A' }}</td>
                            <td>{{ $patient->age ?? '-' }}</td>
                            <td>{{ $patient->glucose ?? '-' }}</td>
                            <td>{{ $patient->blood_pressure ?? '-' }}</td>
                            <td>{{ $patient->bmi ?? '-' }}</td>
                            <td>
                                @php
                                    $result = json_decode($patient->result, true);
                                    $status = $result['status'] ?? 'Pending';
                                @endphp
                                <span class="badge bg-{{ $status === 'Pending' ? 'warning' : 'success' }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td>{{ $patient->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this patient?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
@endsection
