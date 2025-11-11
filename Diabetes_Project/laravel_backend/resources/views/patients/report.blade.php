<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Patient Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        h2 {
            text-align: center;
            background: #0d6efd;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
        }
        h3 {
            margin-top: 30px;
            color: #0d6efd;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #f8f9fa;
        }
        .prediction-table {
            margin-top: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 12px;
            color: #666;
        }
        .status {
            font-weight: bold;
            text-transform: uppercase;
        }
        .diabetic { color: red; }
        .non-diabetic { color: green; }
    </style>
</head>
<body>
    <h2>Patient Health Report 🩺</h2>

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

    @php
        // Decode result safely
        $result = is_array($patient->result) ? $patient->result : json_decode($patient->result, true);
    @endphp

    @if($result)
        <h3>Model Accuracies</h3>
        <table class="prediction-table">
            <thead>
                <tr>
                    <th>Model</th>
                    <th>Accuracy (%)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($result['accuracies'] ?? [] as $model => $accuracy)
                    <tr>
                        <td>{{ $model }}</td>
                        <td>{{ $accuracy }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Prediction Results</h3>
        <table class="prediction-table">
            <thead>
                <tr>
                    <th>Model</th>
                    <th>Prediction</th>
                </tr>
            </thead>
            <tbody>
                @foreach($result['predictions'] ?? [] as $model => $prediction)
                    <tr>
                        <td>{{ $model }}</td>
                        <td class="status {{ strtolower(str_replace(' ', '-', $prediction)) }}">
                            {{ $prediction }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        <p>Generated on {{ now()->format('F d, Y h:i A') }} by Diabetes Detection System</p>
    </div>
</body>
</html>
