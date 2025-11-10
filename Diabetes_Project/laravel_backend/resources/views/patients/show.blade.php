@extends('layouts.app')
@section('content')
<div class="container">
  <div class="card p-3">
    <h3>{{ $patient->name }}</h3>
    <p>Age: {{ $patient->age }} | BMI: {{ $patient->bmi }}</p>
    <h5>Model Predictions</h5>
    <table class="table">
      <thead><tr><th>Model</th><th>Prediction</th><th>Accuracy</th></tr></thead>
      <tbody>
        @foreach($patient->result['predictions'] ?? [] as $model => $pred)
        <tr>
          <td>{{ $model }}</td>
          <td class="{{ $pred=='Diabetic' ? 'text-danger' : 'text-success' }}">{{ $pred }}</td>
          <td>{{ $patient->result['accuracies'][$model] ?? 'N/A' }}%</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <a href="{{ route('patients.download',$patient) }}" class="btn btn-primary">Download PDF</a>
  </div>
</div>
@endsection
