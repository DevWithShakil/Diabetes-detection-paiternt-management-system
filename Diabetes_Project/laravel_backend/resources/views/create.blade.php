<!DOCTYPE html>
<html>
<head>
  <title>Diabetes Detection</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="card p-4 shadow">
    <h2 class="text-center mb-4">Diabetes Detection</h2>
    <form action="/predict" method="POST">
      @csrf
      <div class="row">
        <div class="col-md-6 mb-3"><label>Name</label><input type="text" name="name" class="form-control" required></div>
        <div class="col-md-6 mb-3"><label>Age</label><input type="number" name="age" class="form-control" required></div>
        <div class="col-md-6 mb-3"><label>Glucose</label><input type="number" name="glucose" class="form-control" required></div>
        <div class="col-md-6 mb-3"><label>Blood Pressure</label><input type="number" name="blood_pressure" class="form-control" required></div>
        <div class="col-md-6 mb-3"><label>Skin Thickness</label><input type="number" name="skin_thickness" class="form-control" required></div>
        <div class="col-md-6 mb-3"><label>Insulin</label><input type="number" name="insulin" class="form-control" required></div>
        <div class="col-md-6 mb-3"><label>BMI</label><input type="number" step="0.1" name="bmi" class="form-control" required></div>
        <div class="col-md-6 mb-3"><label>Diabetes Pedigree Function</label><input type="number" step="0.01" name="diabetes_pedigree" class="form-control" required></div>
      </div>
      <div class="text-center"><button type="submit" class="btn btn-primary">Predict</button></div>
    </form>
  </div>
</div>
</body>
</html>
