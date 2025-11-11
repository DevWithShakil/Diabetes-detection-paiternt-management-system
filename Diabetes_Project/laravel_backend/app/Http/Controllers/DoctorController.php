<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\DoctorNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class DoctorController extends Controller
{
    // Show all doctors with search + pagination
    public function index(Request $request)
    {
        $search = $request->input('search');

        $doctors = User::where('role', 'doctor')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'ILIKE', "%{$search}%")
                            ->orWhere('email', 'ILIKE', "%{$search}%")
                            ->orWhere('specialization', 'ILIKE', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('doctors.index', compact('doctors', 'search'));
    }

    // Show create form
    public function create()
    {
        return view('doctors.create');
    }

    // Store new doctor
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'specialization' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'doctor',
            'specialization' => $validated['specialization'] ?? null,
            'phone' => $validated['phone'] ?? null,
        ]);

        return redirect()->route('doctors.index')->with('success', 'Doctor created successfully!');
    }

    // Edit doctor form
    public function edit(User $doctor)
    {
        return view('doctors.edit', compact('doctor'));
    }

    // Update doctor
   public function update(Request $request, User $doctor)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $doctor->id,
        'specialization' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:20',
        'password' => 'nullable|min:6|confirmed', // 🔐 password optional
    ]);

    // Update doctor info
    $doctor->name = $validated['name'];
    $doctor->email = $validated['email'];
    $doctor->specialization = $validated['specialization'] ?? null;
    $doctor->phone = $validated['phone'] ?? null;

    // ✅ Update password only if provided
    if (!empty($validated['password'])) {
        $doctor->password = Hash::make($validated['password']);
    }

    $doctor->save();

    return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully!');
}

    // Delete doctor
    public function destroy(User $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully!');
    }

    // ✅ Dashboard Overview
    public function dashboard()
    {
        $doctorId = auth()->id();

        $appointments = Appointment::where('doctor_id', $doctorId)
            ->with('patient')
            ->orderBy('appointment_date', 'desc')
            ->take(10)
            ->get();

        $total = $appointments->count();
        $pending = $appointments->where('status', 'pending')->count();
        $approved = $appointments->where('status', 'approved')->count();

        return view('doctor.dashboard', compact('appointments', 'total', 'pending', 'approved'));
    }


    // ✅ Approve appointment
    public function approve(Appointment $appointment)
    {
        $appointment->update(['status' => 'approved']);

        // (Optional) Email notification to patient
        // Mail::to($appointment->patient->email)->send(new AppointmentApprovedMail($appointment));

        return back()->with('success', 'Appointment approved successfully.');
    }

    // ✅ Cancel appointment
    public function cancel(Appointment $appointment)
    {
        $appointment->update(['status' => 'cancelled']);
        return back()->with('warning', 'Appointment cancelled.');
    }

    // ✅ View patient report
    public function viewReport(Patient $patient)
    {
        $result = is_array($patient->result)
            ? $patient->result
            : json_decode($patient->result, true);

        $pdf = Pdf::loadView('patients.report', compact('patient', 'result'));
        return $pdf->stream('Patient_Report_' . $patient->name . '.pdf');
    }

    // ✅ Store doctor notes
    public function storeNote(Request $request, Appointment $appointment)
    {
        $request->validate(['note' => 'required|string|max:1000']);

        DoctorNote::create([
            'appointment_id' => $appointment->id,
            'doctor_id' => auth()->id(),
            'note' => $request->note,
        ]);

        return back()->with('success', 'Note added successfully.');
    }
}
