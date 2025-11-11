@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-primary">👨‍⚕️ Welcome, Dr. {{ auth()->user()->name }}</h2>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-left-primary p-3">
                <h5>Total Appointments</h5>
                <h3>{{ $totalAppointments }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-left-warning p-3">
                <h5>Pending</h5>
                <h3>{{ $pendingCount }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-left-success p-3">
                <h5>Approved</h5>
                <h3>{{ $approvedCount }}</h3>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">Recent Appointments</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $a)
                    <tr>
                        <td>{{ $a->patient->name ?? 'Unknown' }}</td>
                        <td>{{ \Carbon\Carbon::parse($a->appointment_date)->format('M d, Y') }}</td>
                        <td><span class="badge bg-{{ $a->status == 'approved' ? 'success' : ($a->status == 'pending' ? 'warning' : 'danger') }}">{{ ucfirst($a->status) }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
