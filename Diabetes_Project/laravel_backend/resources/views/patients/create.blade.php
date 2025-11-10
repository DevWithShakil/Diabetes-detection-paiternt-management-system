@extends('layouts.app')
@section('content')
<div class="container">
  @if(session('success')) <div class="alert alert-success">{{session('success')}}</div> @endif
  <div class="card p-4">
    <h4>New Patient / Predict</h4>
    <form method="POST" action="{{ route('patients.store') }}">
      @csrf
      <div class="row">
        <div class="col-md-6"><label>Name</label><input name="name" class="form-control" required></div>
        <div class="col-md-2"><label>Age</label><input name="age" type="number" class="form-control" required></div>
        <div class="col-md-4"><label>Glucose</label><input name="glucose" type="number" class="form-control" required></div>
        <div class="col-md-4"><label>Blood Pressure</label><input name="blood_pressure" type="number" class="form-control" required></div>
        <div class="col-md-4"><label>Skin Thickness</label><input name="skin_thickness" type="number" class="form-control" required></div>
        <div class="col-md-4"><label>Insulin</label><input name="insulin" type="number" class="form-control" required></div>
        <div class="col-md-4"><label>BMI</label><input name="bmi" step="0.1" class="form-control" required></div>
        <div class="col-md-4"><label>Pedigree</label><input name="diabetes_pedigree" step="0.01" class="form-control" required></div>
      </div>

      <div class="mt-3">
        <label>Select Models (leave blank to use all)</label><br/>
        <select name="models[]" multiple class="form-control">
          <option value="Logistic Regression">Logistic Regression</option>
          <option value="Random Forest">Random Forest</option>
          <option value="SVM">SVM</option>
          <option value="KNN">KNN</option>
          <option value="Decision Tree">Decision Tree</option>
        </select>
      </div>

      <div class="mt-3 text-end">
        <button class="btn btn-primary">Predict & Save</button>
      </div>
    </form>
  </div>
</div>
@endsection
