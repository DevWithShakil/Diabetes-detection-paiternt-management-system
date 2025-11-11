<h3>New Appointment Created</h3>
<p>Patient: {{ $appointment->patient->name }}</p>
<p>Doctor: {{ $appointment->doctor->name }}</p>
<p>Date: {{ $appointment->appointment_date }}</p>
<p><strong>Status:</strong> {{ $appointment->status ?? 'Pending' }}</p>


