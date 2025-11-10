@extends('layouts.app')

@section('content')
<div class="container mt-5">

    {{-- ✅ Success Message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h2 class="mb-4 text-center">All Doctors</h2>

    <div class="text-end mb-3">
        <a href="{{ route('doctors.create') }}" class="btn btn-primary">+ Add New Doctor</a>
    </div>

    @if($doctors->count() > 0)
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Specialization</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($doctors as $doctor)
                <tr>
                    <td>{{ $doctor->id }}</td>
                    <td>{{ $doctor->name }}</td>
                    <td>{{ $doctor->email }}</td>
                    <td>{{ $doctor->specialization }}</td>
                    <td>{{ $doctor->phone ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this doctor?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $doctors->links() }}
        </div>
    @else
        <p class="text-center text-muted">No doctors found.</p>
    @endif
</div>
@endsection
