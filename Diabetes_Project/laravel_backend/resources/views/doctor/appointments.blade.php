@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">📅 Your Appointments</h3>

    <table class="table table-striped shadow-sm">
        <thead>
            <tr>
                <th>Patient</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $a)
                <tr>
                    <td>{{ $a->patient->name ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($a->appointment_date)->format('M d, Y') }}</td>
                    <td>{{ $a->time ?? '--' }}</td>
                    <td>
                        <span class="badge bg-{{ $a->status === 'approved' ? 'success' : ($a->status === 'pending' ? 'warning' : 'danger') }}">
                            {{ ucfirst($a->status) }}
                        </span>
                    </td>
                    <td>{{ $a->notes ?? '—' }}</td>
                    <td>
                        @if($a->status === 'pending')
                            <form action="{{ route('doctor.appointments.approve', $a) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-success btn-sm">Approve</button>
                            </form>
                            <form action="{{ route('doctor.appointments.cancel', $a) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-danger btn-sm">Cancel</button>
                            </form>
                        @else
                            <em>No action</em>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted">No appointments found.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $appointments->links() }}
</div>
@endsection
