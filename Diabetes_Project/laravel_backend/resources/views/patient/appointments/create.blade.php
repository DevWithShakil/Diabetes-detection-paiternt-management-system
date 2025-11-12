@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">🩺 Book a New Appointment</h3>

    <form method="POST" action="{{ route('patient.appointments.store') }}">
        @csrf
        <div class="mb-3">
            <label for="doctor" class="form-label">Select Doctor</label>
            <select name="doctor_id" id="doctor" class="form-select" required>
                <option value="">-- Choose Doctor --</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->name }} ({{ $doctor->specialization }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Appointment Date</label>
            <input type="date" name="appointment_date" id="date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Confirm Appointment</button>
        <a href="{{ route('patient.appointments') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
