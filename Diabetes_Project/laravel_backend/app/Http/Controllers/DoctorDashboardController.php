<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class DoctorDashboardController extends Controller
{
    // Doctor Dashboard Home
    public function index()
    {
        $doctor = Auth::user();
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->orderBy('appointment_date', 'desc')
            ->take(5)
            ->get();

        $totalAppointments = Appointment::where('doctor_id', $doctor->id)->count();
        $pendingCount = Appointment::where('doctor_id', $doctor->id)->where('status', 'pending')->count();
        $approvedCount = Appointment::where('doctor_id', $doctor->id)->where('status', 'approved')->count();

        return view('doctor.dashboard', compact('doctor', 'appointments', 'totalAppointments', 'pendingCount', 'approvedCount'));
    }

    // Show all appointments for doctor
    public function appointments()
    {
        $doctor = Auth::user();
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

        return view('doctor.appointments', compact('appointments'));
    }

    // Approve appointment
    public function approve(Appointment $appointment)
    {
        $this->authorizeDoctor($appointment);

        $appointment->update(['status' => 'approved']);
        return back()->with('success', 'Appointment approved successfully!');
    }

    // Cancel appointment
    public function cancel(Appointment $appointment)
    {
        $this->authorizeDoctor($appointment);

        $appointment->update(['status' => 'cancelled']);
        return back()->with('success', 'Appointment cancelled.');
    }

    // Private helper
    private function authorizeDoctor(Appointment $appointment)
    {
        if ($appointment->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
