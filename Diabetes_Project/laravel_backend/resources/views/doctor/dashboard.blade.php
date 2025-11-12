@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4 text-primary">
        🩺 Welcome, {{ auth()->user()->name }}
    </h3>

    <div class="row text-center mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Total Appointments</h5>
                    <h2>{{ $total }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Pending</h5>
                    <h2 class="text-warning">{{ $pending }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Approved</h5>
                    <h2 class="text-success">{{ $approved }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            Recent Appointments
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->patient->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</td>
                            <td>
                                <span class="badge
                                    @if($appointment->status == 'approved') bg-success
                                    @elseif($appointment->status == 'pending') bg-warning text-dark
                                    @else bg-danger @endif">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>
                            <td>
                                @if($appointment->status == 'pending')
                                    <form action="{{ route('doctor.appointments.approve', $appointment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-success btn-sm">Approve</button>
                                    </form>
                                    <form action="{{ route('doctor.appointments.cancel', $appointment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-danger btn-sm">Cancel</button>
                                    </form>
                                @endif
                                <a href="{{ route('doctor.patients.report', $appointment->patient->id) }}" class="btn btn-info btn-sm">View Report</a>
                            </td>
                        </tr>

                        {{-- 👇 Doctor Notes Section --}}
                        <tr>
                            <td colspan="4" class="bg-light">
                                <strong>Doctor Notes:</strong>
                               @if(!empty($appointment->notes) && count($appointment->notes) > 0)
    @foreach ($appointment->notes as $note)
        <div class="border p-2 mb-1 rounded bg-white">
             <strong>{{ optional($note->doctor)->name }}</strong>:
            {{ $note->note }}
            <small class="text-muted float-end">{{ $note->created_at->diffForHumans() }}</small>
        </div>
    @endforeach
@else
    <p class="text-muted mb-2">No notes yet.</p>
@endif

                                {{-- Add New Note --}}
                                <form action="{{ route('doctor.notes.store', $appointment->id) }}" method="POST" class="mt-2">
                                    @csrf
                                    <textarea name="note" class="form-control mb-2" rows="2" placeholder="Add a new note..."></textarea>
                                    <button type="submit" class="btn btn-primary btn-sm">Add Note</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted p-3">No appointments found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
