<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Patient Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 20px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Patient Report</h2>
    <table>
        <tr><th>Name</th><td>{{ $patient->name }}</td></tr>
        <tr><th>Age</th><td>{{ $patient->age }}</td></tr>
        <tr><th>Glucose</th><td>{{ $patient->glucose }}</td></tr>
        <tr><th>Blood Pressure</th><td>{{ $patient->blood_pressure }}</td></tr>
        <tr><th>Skin Thickness</th><td>{{ $patient->skin_thickness }}</td></tr>
        <tr><th>Insulin</th><td>{{ $patient->insulin }}</td></tr>
        <tr><th>BMI</th><td>{{ $patient->bmi }}</td></tr>
        <tr><th>Diabetes Pedigree</th><td>{{ $patient->diabetes_pedigree }}</td></tr>
    </table>

    <h4 style="margin-top:20px;">Prediction Results:</h4>
    @php
        $data = is_array($patient->result) ? $patient->result : json_decode($patient->result, true);
    @endphp
    <ul>
        @foreach($data['predictions'] ?? [] as $model => $prediction)
            <li><strong>{{ $model }}:</strong> {{ $prediction }}</li>
        @endforeach
    </ul>
</body>
</html>
