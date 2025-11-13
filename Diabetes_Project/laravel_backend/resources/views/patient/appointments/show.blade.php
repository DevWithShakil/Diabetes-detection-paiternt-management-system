@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">🩺 Appointment Details</h4>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h6><strong>Doctor Name:</strong></h6>
                    <p>{{ $appointment->doctor->name ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <h6><strong>Specialization:</strong></h6>
                    <p>{{ $appointment->doctor->specialization ?? 'Not specified' }}</p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <h6><strong>Appointment Date:</strong></h6>
                    <p>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}</p>
                </div>
                <div class="col-md-6">
                    <h6><strong>Status:</strong></h6>
                    <span class="badge
                        @if($appointment->status == 'approved') bg-success
                        @elseif($appointment->status == 'pending') bg-warning text-dark
                        @else bg-danger @endif">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </div>
            </div>

            @if($appointment->time)
            <div class="row mb-3">
                <div class="col-md-6">
                    <h6><strong>Time Slot:</strong></h6>
                    <p>{{ $appointment->time }}</p>
                </div>
            </div>
            @endif

            <hr>

            <h5 class="text-primary mt-3 mb-2">🩸 Doctor’s Notes</h5>

            @php
                $notes = $appointment->notes ?? collect();
            @endphp

            @if($notes->isNotEmpty())
                <ul class="list-group">
                    @foreach($notes as $note)
                        <li class="list-group-item">
                            <p class="mb-1">{{ $note->note }}</p>
                            <small class="text-muted">Added on {{ \Carbon\Carbon::parse($note->created_at)->format('F d, Y h:i A') }}</small>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">No doctor notes yet.</p>
            @endif

            <div class="mt-4">
                <a href="{{ route('patient.appointments') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Appointments
                </a>

                {{-- @if($appointment->status === 'approved')
                    <a href="{{ route('patient.report', $appointment->patient_id) }}" class="btn btn-primary">
                        <i class="bi bi-file-medical"></i> View Report
                    </a>
                @endif --}}
            </div>
        </div>
    </div>

</div>
@endsection
