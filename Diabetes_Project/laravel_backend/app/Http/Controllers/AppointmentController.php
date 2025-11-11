<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
// use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentMail;
use App\Models\User;


class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
        ->whereHas('doctor', function ($q) {
            $q->where('role', 'doctor'); // ✅ only real doctors
        })
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
     $patients = Patient::all(); // ✅ এখানে variable define করা হলো
    $doctors = User::where('role', 'doctor')->get(); // ✅ doctor গুলো users টেবিল থেকে আসছে

    return view('appointments.create', compact('patients', 'doctors'));
}

    public function store(Request $r)
    {
       $data = $r->validate([
    'patient_id' => 'required|exists:patients,id',
    'doctor_id' => 'required|exists:users,id',
    'appointment_date' => 'required|date',
]);

$data['status'] = 'pending';
$data['time'] = $r->input('time');
$data['notes'] = $r->input('notes');

$appointment = Appointment::create($data);

Mail::to('doctor@example.com')->send(new AppointmentMail($appointment));

return redirect()->route('appointments.index')->with('success', 'Appointment created successfully!');

    }

    public function updateStatus(Request $r, Appointment $appointment)
    {
        $r->validate(['status' => 'required|string']);
        $appointment->update(['status' => $r->status]);
        return back()->with('success', 'Status updated!');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return back()->with('success', 'Appointment deleted.');
    }
}
