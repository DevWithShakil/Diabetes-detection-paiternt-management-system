@extends('layouts.app')
@section('content')
<div class="container">
  <div class="mb-3">
    <a href="{{ route('patients.create') }}" class="btn btn-success">New Patient</a>
  </div>
  <table class="table table-bordered">
    <thead><tr><th>#</th><th>Name</th><th>Age</th><th>Result</th><th>Date</th><th>Action</th></tr></thead>
    <tbody>
      @foreach($patients as $p)
      <tr>
        <td>{{ $p->id }}</td>
        <td>{{ $p->name }}</td>
        <td>{{ $p->age }}</td>
        <td>
          @php $pred = $p->result['predictions'] ?? []; $major = collect($pred)->filter(fn($v)=>$v==='Diabetic')->count() >= ceil(count($pred)/2); @endphp
          <span class="{{ $major ? 'text-danger' : 'text-success' }}">{{ $major ? 'Diabetic' : 'Non-Diabetic' }}</span>
        </td>
        <td>{{ $p->created_at->format('Y-m-d') }}</td>
        <td>
          <a href="{{ route('patients.show', $p) }}" class="btn btn-sm btn-info">View</a>
          <a href="{{ route('patients.download',$p) }}" class="btn btn-sm btn-secondary">PDF</a>
          <form action="{{ route('patients.destroy',$p) }}" method="POST" style="display:inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Del</button></form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  {{ $patients->links() }}
</div>
@endsection
