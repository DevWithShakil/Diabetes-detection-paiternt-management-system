@extends('layouts.app')

@section('content')
<div class="container">
    <h2>New Appointment</h2>

    <form method="POST" action="{{ route('appointments.store') }}">
        @csrf
        <div class="mb-3">
            <label>Patient</label>
            <select name="patient_id" class="form-control">
                @foreach($patients as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Doctor</label>
            <select name="doctor_id" class="form-control">
                @foreach($doctors as $d)
                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Appointment Date</label>
            <input type="date" name="appointment_date" class="form-control">
        </div>

        <button class="btn btn-success">Save Appointment</button>
    </form>
</div>
@endsection
