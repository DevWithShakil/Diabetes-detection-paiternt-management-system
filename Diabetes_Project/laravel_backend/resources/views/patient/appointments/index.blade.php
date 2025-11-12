@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">📅 My Appointments</h3>

    <a href="{{ route('patient.appointments.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-circle"></i> Book New Appointment
    </a>

    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Doctor</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $index => $appointment)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $appointment->doctor->name ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}</td>
                    <td>
                        <span class="badge
                            @if($appointment->status == 'approved') bg-success
                            @elseif($appointment->status == 'pending') bg-warning text-dark
                            @else bg-danger @endif">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('patient.appointments.show', $appointment->id) }}" class="btn btn-sm btn-primary">
                            View
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">No appointments yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
