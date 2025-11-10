<!DOCTYPE html>
<html>
<head>
  <title>Prediction Result</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="card shadow p-4">
    <h3 class="mb-4 text-center">Model Comparison Results</h3>
    <table class="table table-bordered">
      <thead><tr><th>Model</th><th>Prediction</th><th>Accuracy (%)</th></tr></thead>
      <tbody>
        @foreach ($data['predictions'] as $model => $result)
        <tr>
          <td>{{ $model }}</td>
          <td>{{ $result }}</td>
          <td>{{ $data['accuracies'][$model] }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="text-center">
      <a href="/" class="btn btn-secondary">← Back</a>
    </div>
  </div>
</div>
</body>
</html>
