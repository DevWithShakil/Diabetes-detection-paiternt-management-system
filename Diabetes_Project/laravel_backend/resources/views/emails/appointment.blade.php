<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmation</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #0d6efd;
            color: #fff;
            text-align: center;
            padding: 25px 10px;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 25px;
            color: #333;
        }
        .content h3 {
            margin-bottom: 10px;
            color: #0d6efd;
        }
        .details {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
            border-left: 5px solid #0d6efd;
        }
        .details p {
            margin: 6px 0;
            font-size: 15px;
        }
        .footer {
            text-align: center;
            background-color: #f3f4f6;
            color: #666;
            font-size: 13px;
            padding: 15px;
        }
        .btn {
            display: inline-block;
            background-color: #0d6efd;
            color: #fff !important;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 6px;
            font-weight: 500;
            margin-top: 15px;
        }
        .btn:hover {
            background-color: #0b5ed7;
        }
    </style>
</head>
<body>

    <div class="email-container">
        <div class="header">
            <h2>Appointment Confirmed 🩺</h2>
        </div>

        <div class="content">
            <h3>Dear {{ $appointment->patient->name ?? 'Patient' }},</h3>
            <p>
                Your appointment has been successfully scheduled.
                Below are your appointment details:
            </p>

            <div class="details">
                <p><strong>Patient Name:</strong> {{ $appointment->patient->name ?? 'N/A' }}</p>
                <p><strong>Doctor:</strong> Dr. {{ $appointment->doctor?->name ?? 'N/A' }}</p>
                <p><strong>Specialization:</strong> {{ $appointment->doctor?->specialization ?? 'N/A' }}</p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}</p>
                <p><strong>Time:</strong> {{ $appointment->time ?? 'Not specified' }}</p>
                <p><strong>Status:</strong>
                    <span style="color: {{ $appointment->status === 'approved' ? 'green' : ($appointment->status === 'cancelled' ? 'red' : '#ff9800') }};">
                        {{ ucfirst($appointment->status ?? 'Pending') }}
                    </span>
                </p>
            </div>

            <p>
                Please make sure to arrive 10 minutes before your appointment.<br>
                If you need to reschedule or cancel, kindly contact us at
                <a href="mailto:support@diabetesapp.com">support@diabetesapp.com</a>.
            </p>

            <a href="http://127.0.0.1:8000/login" class="btn">View Appointment</a>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} Diabetes Detection System. All Rights Reserved.</p>
        </div>
    </div>

</body>
</html>
