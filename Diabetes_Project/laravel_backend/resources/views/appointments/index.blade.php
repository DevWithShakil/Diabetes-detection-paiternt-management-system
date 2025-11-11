@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Appointments</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('appointments.create') }}" class="btn btn-primary mb-3">+ New Appointment</a>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Patient</th>
            <th>Doctor</th>
            <th>Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        @foreach($appointments as $a)
        <tr>
            <td>{{ $a->id }}</td>
            <td>{{ $a->patient->name }}</td>
            <td>{{ $a->doctor->name }}</td>
            <td>{{ $a->appointment_date }}</td>
            <td>{{ ucfirst($a->status) }}</td>
            <td>
                <form action="{{ route('appointments.updateStatus', $a) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                        <option value="pending" {{ $a->status=='pending'?'selected':'' }}>Pending</option>
                        <option value="approved" {{ $a->status=='approved'?'selected':'' }}>Approved</option>
                        <option value="completed" {{ $a->status=='completed'?'selected':'' }}>Completed</option>
                        <option value="cancelled" {{ $a->status=='cancelled'?'selected':'' }}>Cancelled</option>
                    </select>
                </form>
                <form action="{{ route('appointments.destroy', $a) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">🗑</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    {{ $appointments->links() }}
</div>
@endsection
