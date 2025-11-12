@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body bg-primary text-white rounded">
                    <h3 class="mb-1">Welcome, {{ $patient->name ?? Auth::user()->name }} 👋</h3>
                    <p class="mb-0">Your personal diabetes monitoring dashboard</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- ✅ Latest Report --}}
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title mb-3">🩺 Latest Report</h5>
                    @if($latestReport)
                        <p class="mb-1"><strong>Date:</strong> {{ \Carbon\Carbon::parse($latestReport->updated_at)->format('F d, Y') }}</p>
                        <p class="mb-2"><strong>Status:</strong>
                            <span class="badge bg-success">Available</span>
                        </p>
                        <a href="{{ route('patient.report', $patient->id) }}" class="btn btn-sm btn-outline-primary">View Report</a>
                        <a href="{{ route('patient.report.download', $patient->id) }}" class="btn btn-sm btn-outline-dark">Download PDF</a>
                    @else
                        <p>No report found.</p>
                        <a href="{{ route('patient.detection') }}" class="btn btn-sm btn-primary">Run Detection</a>
                    @endif
                </div>
            </div>
        </div>

        {{-- ✅ Next Appointment --}}
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title mb-3">📅 Next Appointment</h5>
                    @if($nextAppointment)
                        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($nextAppointment->appointment_date)->format('F d, Y') }}</p>
                        <p><strong>Status:</strong>
                            <span class="badge
                                @if($nextAppointment->status == 'approved') bg-success
                                @elseif($nextAppointment->status == 'pending') bg-warning text-dark
                                @else bg-danger
                                @endif">
                                {{ ucfirst($nextAppointment->status) }}
                            </span>
                        </p>
                        @if($nextAppointment->doctor)
                            <p><strong>Doctor:</strong> {{ $nextAppointment->doctor->name }}</p>
                        @endif
                    @else
                        <p>No upcoming appointment.</p>
                        <a href="{{ route('patient.appointment.create') }}" class="btn btn-sm btn-primary">Book Now</a>
                    @endif
                </div>
            </div>
        </div>

        {{-- ✅ Statistics Card --}}
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title mb-3">📊 My Statistics</h5>
                    <p class="mb-1"><strong>Total Appointments:</strong> {{ $appointmentsCount ?? 0 }}</p>
                    <p class="mb-1"><strong>Report Status:</strong>
                        @if($latestReport)
                            <span class="text-success fw-semibold">Completed</span>
                        @else
                            <span class="text-muted">Pending</span>
                        @endif
                    </p>
                    <hr>
                    <a href="{{ route('patient.appointments') }}" class="btn btn-sm btn-outline-primary">View All Appointments</a>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ Quick Actions --}}
    <div class="text-center mt-5">
        <a href="{{ route('patient.detection') }}" class="btn btn-primary me-2">🧪 New Detection</a>
        <a href="{{ route('patient.appointments') }}" class="btn btn-success me-2">📅 My Appointments</a>
        @if($latestReport)
            <a href="{{ route('patient.report.download', $patient->id) }}" class="btn btn-outline-dark">⬇️ Download Report</a>
        @endif
    </div>
</div>
@endsection
