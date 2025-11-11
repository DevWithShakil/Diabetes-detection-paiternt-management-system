@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Edit Doctor</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Please fix the following issues:<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('doctors.update', $doctor->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card p-4 shadow-sm">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ $doctor->name }}" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ $doctor->email }}" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Specialization</label>
                    <input type="text" name="specialization" value="{{ $doctor->specialization }}" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Phone</label>
                    <input type="text" name="phone" value="{{ $doctor->phone }}" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>New Password <small class="text-muted">(optional)</small></label>
                    <input type="password" name="password" class="form-control" placeholder="Enter new password if you want to change">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Re-enter new password">
                </div>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('doctors.index') }}" class="btn btn-secondary">← Back</a>
                <button type="submit" class="btn btn-primary">Update Doctor</button>
            </div>
        </div>
    </form>
</div>
@endsection
