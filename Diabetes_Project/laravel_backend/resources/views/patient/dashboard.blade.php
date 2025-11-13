@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h3 class="mb-3">Welcome, {{ $patient->name }} 👋</h3>

    {{-- Status Message --}}
    <div class="alert alert-warning">
        @if($nextAppointment && $nextAppointment->status === 'pending')
            Status: Under doctor review.
            <br>Your recent test data is waiting for doctor analysis.
        @elseif($nextAppointment && $nextAppointment->status === 'approved')
            Status: Approved.
            <br>Your doctor has reviewed your test results.
        @endif
    </div>

    <div class="row g-4">

        {{-- Next Appointment --}}
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">

                    <h5>📅 Next Appointment</h5>

                    @if($nextAppointment)
                        <p><strong>Date:</strong>
                            {{ \Carbon\Carbon::parse($nextAppointment->appointment_date)->format('F d, Y') }}
                        </p>

                        <p><strong>Status:</strong>
                            <span class="badge
                                @if($nextAppointment->status == 'approved') bg-success
                                @elseif($nextAppointment->status == 'pending') bg-warning text-dark
                                @else bg-danger @endif">
                                {{ ucfirst($nextAppointment->status) }}
                            </span>
                        </p>

                        <p><strong>Doctor:</strong> {{ $nextAppointment->doctor->name }}</p>

                        {{-- 🌟 Doctor Notes --}}
                        @php
                            $latestNote = $nextAppointment->notes->sortByDesc('created_at')->first();
                        @endphp

                        @if($latestNote)
                            <div class="alert alert-info">
                                <strong>Doctor Note:</strong><br>
                                {{ $latestNote->note }}
                                <br>
                                <small class="text-muted">{{ $latestNote->created_at->diffForHumans() }}</small>
                            </div>
                        @endif

                    @else
                        <p>No upcoming appointment.</p>
                        <a href="{{ route('patient.appointments.create') }}" class="btn btn-primary btn-sm">Book Now</a>
                    @endif

                </div>
            </div>
        </div>


        {{-- My Statistics --}}
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>📊 My Statistics</h5>

                    <p><strong>Total Appointments:</strong> {{ $appointmentsCount }}</p>

                    {{-- Diabetes Result Section --}}
                    @php

                        $report = json_decode($patient->result, true);

                        $finalPrediction = null;

                        if (isset($report['predictions']) && is_array($report['predictions'])) {

                            // সব result lowercase
                            $votes = collect($report['predictions'])->map(function($v){
                                return strtolower(trim($v));
                            });

                            $diabeticVotes = $votes->filter(fn($v) => $v === 'diabetic')->count();
                            $nonVotes     = $votes->filter(fn($v) => $v === 'non-diabetic')->count();

                            if ($diabeticVotes > $nonVotes) {
                                $finalPrediction = 1; // diabetic
                            } elseif ($nonVotes > $diabeticVotes) {
                                $finalPrediction = 0; // non
                            }
                        }

                    @endphp

                    <p><strong>Latest Test:</strong>

                        @if(!$nextAppointment || $nextAppointment->status === 'pending')
                            <span class="text-warning fw-semibold">Under review</span>
                        @else
                            @if($finalPrediction === 1)
                                <span class="badge bg-danger">Diabetic</span>
                            @elseif($finalPrediction === 0)
                                <span class="badge bg-success">Non-Diabetic</span>
                            @else
                                <span class="badge bg-secondary">No Result</span>
                            @endif
                        @endif
                    </p>

                    <a href="{{ route('patient.appointments') }}" class="btn btn-outline-primary btn-sm">
                        View All Appointments
                    </a>

                </div>
            </div>
        </div>

    </div>

    {{-- Action Buttons --}}
    <div class="text-center mt-4">
        <a href="{{ route('patient.simpletest') }}" class="btn btn-primary">🧪 Add Test Data</a>
        <a href="{{ route('patient.appointments') }}" class="btn btn-success">📅 My Appointments</a>
    </div>

</div>
@endsection
