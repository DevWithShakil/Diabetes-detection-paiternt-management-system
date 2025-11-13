@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3 class="mb-4 text-primary">
        🩺 Welcome, {{ auth()->user()->name }}
    </h3>

    {{-- Summary Cards --}}
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

    {{-- Recent Appointments --}}
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
                        <th>Diabetes</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($appointments as $appointment)

                        {{-- 🌟 Final Prediction Calculator --}}
                        @php
                            $report = json_decode($appointment->patient->result, true);
                            $prediction = null; // final output (1=Diabetic, 0=Non)

                            if (isset($report['predictions']) && is_array($report['predictions'])) {
                                $votes = collect($report['predictions'])->map(fn($v) => strtolower($v));

                                $diabeticCount = $votes->filter(fn($v) => $v === "diabetic")->count();
                                $nonCount = $votes->filter(fn($v) => $v === "non-diabetic")->count();

                                if ($diabeticCount > $nonCount) {
                                    $prediction = 1;
                                } elseif ($nonCount > $diabeticCount) {
                                    $prediction = 0;
                                } else {
                                    $prediction = null; // tie or no data
                                }
                            }
                        @endphp

                        <tr>
                            {{-- Patient --}}
                            <td>{{ $appointment->patient->name }}</td>

                            {{-- Date --}}
                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</td>

                            {{-- Status --}}
                            <td>
                                <span class="badge
                                    @if($appointment->status == 'approved') bg-success
                                    @elseif($appointment->status == 'pending') bg-warning text-dark
                                    @else bg-danger @endif">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>

                            {{-- 🌟 Diabetes Result --}}
                            <td>
                                @if($prediction === 1)
                                    <span class="badge bg-danger">Diabetic</span>

                                @elseif($prediction === 0)
                                    <span class="badge bg-success">Non-Diabetic</span>

                                @else
                                    <span class="badge bg-secondary">No Result</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td>
                                @if($appointment->status == 'pending')
                                    <form action="{{ route('doctor.appointments.approve', $appointment->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-success btn-sm">Approve</button>
                                    </form>

                                    <form action="{{ route('doctor.appointments.cancel', $appointment->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-danger btn-sm">Cancel</button>
                                    </form>
                                @endif

                                <a href="{{ route('doctor.patients.report', $appointment->patient->id) }}"
                                   class="btn btn-info btn-sm">
                                    View Report
                                </a>
                            </td>
                        </tr>


                        {{-- Notes Section --}}
                        <tr>
                            <td colspan="5" class="bg-light">
                                <strong>Doctor Notes:</strong>

                                @if ($appointment->notes && count($appointment->notes) > 0)
                                    @foreach ($appointment->notes as $note)
                                        <div class="border p-2 mb-1 rounded bg-white">
                                            <strong>{{ optional($note->doctor)->name }}</strong>:
                                            {{ $note->note }}
                                            <small class="text-muted float-end">
                                                {{ $note->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-muted mb-2">No notes yet.</p>
                                @endif

                                {{-- Add new note --}}
                                <form action="{{ route('doctor.notes.store', $appointment->id) }}"
                                      method="POST" class="mt-2">
                                    @csrf
                                    <textarea name="note" class="form-control mb-2" rows="2"
                                              placeholder="Add a new note..."></textarea>
                                    <button type="submit" class="btn btn-primary btn-sm">Add Note</button>
                                </form>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center text-muted p-3">
                                No appointments found
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>
    </div>
</div>
@endsection
