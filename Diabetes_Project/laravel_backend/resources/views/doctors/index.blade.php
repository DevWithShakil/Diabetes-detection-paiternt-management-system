@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Manage Doctors</h2>

    <!-- Search and Add Button -->
    <div class="mb-3 d-flex justify-content-between">
        <form action="{{ route('doctors.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control me-2" placeholder="Search by name, email, or specialization">
            <button class="btn btn-primary">Search</button>
        </form>
        <a href="{{ route('doctors.create') }}" class="btn btn-success">+ Add New Doctor</a>
    </div>

    <!-- Table -->
    <table class="table table-bordered align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Specialization</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($doctors as $doctor)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $doctor->name }}</td>
                    <td>{{ $doctor->email }}</td>
                    <td>{{ $doctor->specialization }}</td>
                    <td>{{ $doctor->phone }}</td>
                    <td>
                        <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this doctor?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">No doctors found</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $doctors->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
