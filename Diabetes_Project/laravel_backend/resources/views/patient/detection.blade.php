<!DOCTYPE html>
<html>
<head>
  <title>Diabetes Detection</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

@if(session('success'))
  <div class="alert alert-success">
      {{ session('success') }}
  </div>
@endif

@if ($errors->any())
  <div class="alert alert-danger">
      <ul class="mb-0">
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif


<div class="container mt-5">
  <div class="card p-4 shadow">
    <h2 class="text-center mb-4 text-primary">🩺 Diabetes Detection</h2>

    <form action="{{ route('patient.detection.store') }}" method="POST">
      @csrf

      <div class="row">

        <!-- NAME (auto-filled + locked) -->
        <div class="col-md-6 mb-3">
          <label>Name</label>

          <!-- disabled visible field -->
          <input
            type="text"
            class="form-control"
            value="{{ $user->name }}"
            disabled
          >

          <!-- hidden real field that submits -->
          <input
            type="hidden"
            name="name"
            value="{{ $user->name }}"
          >
        </div>

        <div class="col-md-6 mb-3">
          <label>Age</label>
          <input type="number" name="age" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
          <label>Glucose</label>
          <input type="number" name="glucose" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
          <label>Blood Pressure</label>
          <input type="number" name="blood_pressure" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
          <label>Skin Thickness</label>
          <input type="number" name="skin_thickness" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
          <label>Insulin</label>
          <input type="number" name="insulin" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
          <label>BMI</label>
          <input type="number" step="0.1" name="bmi" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
          <label>Diabetes Pedigree Function</label>
          <input type="number" step="0.01" name="diabetes_pedigree_function" class="form-control" required>
        </div>

      </div>

      <div class="text-center mt-3">
        <button type="submit" class="btn btn-primary px-4">Submit Data</button>
      </div>

    </form>
  </div>
</div>

</body>
</html>
