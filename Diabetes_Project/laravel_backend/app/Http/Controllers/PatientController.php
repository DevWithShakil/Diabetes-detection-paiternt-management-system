<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;

class PatientController extends Controller
{
    /**
     * 🏠 Show patient dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Find patient profile based on user_id (not id)
        $patient = Patient::where('user_id', $user->id)->first();

        // যদি নতুন patient হয় → তাকে detection form এ পাঠাও
        if (!$patient) {
            return redirect()->route('patient.detection');
        }

        // Default data
        $nextAppointment = Appointment::where('patient_id', $patient->id)
            ->whereDate('appointment_date', '>=', now())
            ->orderBy('appointment_date', 'asc')
            ->first();

        $appointmentsCount = Appointment::where('patient_id', $patient->id)->count();

        $latestReport = Patient::where('id', $patient->id)
            ->orderBy('updated_at', 'desc')
            ->first();

        return view('patient.dashboard', compact('patient', 'nextAppointment', 'latestReport', 'appointmentsCount'));
    }

    /**
     * 📅 Show all appointments for the logged-in patient
     */
    public function appointments()
    {
        $appointments = Appointment::with('doctor')
            ->where('patient_id', Auth::id())
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('patient.appointments.index', compact('appointments'));
    }

    /**
     * ➕ Create appointment form
     */
    public function createAppointment()
    {
        $doctors = User::where('role', 'doctor')->get();
        return view('patient.appointments.create', compact('doctors'));
    }

    /**
     * 💾 Store appointment
     */
    public function storeAppointment(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
        ]);

        Appointment::create([
            'patient_id' => Auth::id(),
            'doctor_id' => $validated['doctor_id'],
            'appointment_date' => $validated['appointment_date'],
            'status' => 'pending',
        ]);

        return redirect()->route('patient.appointments')
            ->with('success', 'Your appointment request has been sent successfully.');
    }

    /**
     * 👁️ Show appointment details
     */
    public function showAppointment($id)
    {
        $appointment = Appointment::with('doctor')
            ->where('id', $id)
            ->where('patient_id', Auth::id())
            ->firstOrFail();

        return view('patient.appointments.show', compact('appointment'));
    }

    /**
     * 📄 View patient report
     */
    public function report(Patient $patient)
    {
        if ($patient->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $result = json_decode($patient->result, true);
        return view('patient.reports.show', compact('patient', 'result'));
    }

    /**
     * ⬇️ Download report as PDF
     */
    public function downloadReport(Patient $patient)
    {
        if ($patient->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $data = [
            'patient' => $patient,
            'result' => json_decode($patient->result, true),
        ];

        $pdf = Pdf::loadView('patient.reports.pdf', $data);
        return $pdf->download('Patient_Report_' . $patient->name . '.pdf');
    }

    /**
     * 🧪 Show detection form (for new users)
     */
    public function showDetectionForm()
    {
        return view('patient.detection');
    }

    /**
     * 💾 Store detection data + ML API prediction
     */
    public function storeDetection(Request $request)
    {
        if (!Auth::check()) {
        return redirect()->route('login')->withErrors(['Please login first']);
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'age' => 'required|numeric',
        'glucose' => 'required|numeric',
        'blood_pressure' => 'required|numeric',
        'skin_thickness' => 'required|numeric',
        'insulin' => 'required|numeric',
        'bmi' => 'required|numeric',
        'diabetes_pedigree_function' => 'required|numeric',
    ]);

    $user = Auth::user();

    try {
        $response = Http::timeout(10)->post('http://127.0.0.1:5000/predict', [
            "Pregnancies" => 0,
            "Glucose" => $validated['glucose'],
            "BloodPressure" => $validated['blood_pressure'],
            "SkinThickness" => $validated['skin_thickness'],
            "Insulin" => $validated['insulin'],
            "BMI" => $validated['bmi'],
            "DiabetesPedigreeFunction" => $validated['diabetes_pedigree_function'],
            "Age" => $validated['age'],
        ]);

        if ($response->successful()) {
            $prediction = $response->json(); // ✅ Flask response as JSON
        } else {
            $prediction = ['status' => 'API Error'];
        }
    } catch (\Exception $e) {
        \Log::error('Flask API Error:', ['message' => $e->getMessage()]);
        $prediction = ['status' => 'Pending'];
    }

    Patient::create([
        'user_id' => $user->id,
        'name' => $validated['name'],
        'age' => $validated['age'],
        'glucose' => $validated['glucose'],
        'blood_pressure' => $validated['blood_pressure'],
        'skin_thickness' => $validated['skin_thickness'],
        'insulin' => $validated['insulin'],
        'bmi' => $validated['bmi'],
        'diabetes_pedigree' => $validated['diabetes_pedigree_function'],
        'result' => json_encode($prediction),
    ]);

    return redirect()->back()->with('success', '✅ Prediction saved successfully!');
    }

    // ======================================================
    // 🔹 Admin: Create Patient Form
    // ======================================================
    public function create()
    {
        return view('admin.patients.create');
    }

    // ======================================================
    // 🔹 Admin: Store Patient
    // ======================================================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'age' => 'required|numeric',
            'glucose' => 'nullable|numeric',
            'blood_pressure' => 'nullable|numeric',
            'skin_thickness' => 'nullable|numeric',
            'insulin' => 'nullable|numeric',
            'bmi' => 'nullable|numeric',
            'diabetes_pedigree' => 'nullable|numeric',
        ]);

        // Step 1: Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt('12345678'),
            'role' => 'patient',
        ]);

        // Step 2: Send data to ML model
        try {
            $response = Http::post('http://127.0.0.1:5000/predict', [
                "Pregnancies" => 0,
                "Glucose" => $validated['glucose'] ?? 0,
                "BloodPressure" => $validated['blood_pressure'] ?? 0,
                "SkinThickness" => $validated['skin_thickness'] ?? 0,
                "Insulin" => $validated['insulin'] ?? 0,
                "BMI" => $validated['bmi'] ?? 0,
                "DiabetesPedigreeFunction" => $validated['diabetes_pedigree'] ?? 0,
                "Age" => $validated['age'],
            ]);

            $prediction = $response->json();
        } catch (\Exception $e) {
            $prediction = ['status' => 'Error', 'message' => $e->getMessage()];
        }

        // Step 3: Create patient record
        Patient::create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'age' => $validated['age'],
            'glucose' => $validated['glucose'] ?? null,
            'blood_pressure' => $validated['blood_pressure'] ?? null,
            'skin_thickness' => $validated['skin_thickness'] ?? null,
            'insulin' => $validated['insulin'] ?? null,
            'bmi' => $validated['bmi'] ?? null,
            'diabetes_pedigree' => $validated['diabetes_pedigree'] ?? null,
            'result' => json_encode($prediction),
        ]);

        return redirect()->route('patients.index')->with('success', '✅ Patient created and prediction saved successfully!');
    }

    // ======================================================
    // 🔹 Admin: Show All Patients
    // ======================================================
    public function index()
    {
        $patients = Patient::with('user')->latest()->get();
        return view('admin.patients.index', compact('patients'));
    }
}
