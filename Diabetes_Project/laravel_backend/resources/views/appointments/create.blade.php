@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">➕ Create New Appointment</h4>
        </div>

        <div class="card-body">
            {{-- Validation Error Alert --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Oops! Something went wrong:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Success Message --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('appointments.store') }}">
                @csrf

                {{-- Patient --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Patient Name</label>
                    <select name="patient_id" class="form-select" required>
                        <option value="" disabled selected>Select Patient</option>
                        @foreach($patients as $p)
                            <option value="{{ $p->id }}" {{ old('patient_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Doctor --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Select Doctor</label>
                    <select name="doctor_id" class="form-select" required>
                        <option value="" disabled selected>Select Doctor</option>
                        @foreach($doctors as $d)
                            <option value="{{ $d->id }}" {{ old('doctor_id') == $d->id ? 'selected' : '' }}>
                                {{ $d->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Appointment Date --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Appointment Date</label>
                    <input type="date" name="appointment_date" class="form-control"
                           value="{{ old('appointment_date') }}" required>
                </div>

                {{-- Time (optional) --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Appointment Time (Optional)</label>
                    <input type="time" name="time" class="form-control" value="{{ old('time') }}">
                </div>

                {{-- Notes (optional) --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Notes / Reason (Optional)</label>
                    <textarea name="notes" rows="3" class="form-control"
                              placeholder="Mention reason or note...">{{ old('notes') }}</textarea>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    💾 Save Appointment
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
