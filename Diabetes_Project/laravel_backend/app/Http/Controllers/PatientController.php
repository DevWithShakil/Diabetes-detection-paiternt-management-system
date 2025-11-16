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
     * 🏠 Patient Dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Always fetch the latest patient record
        $patient = Patient::where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->first();

        if (!$patient) {
            return redirect()->route('patient.detection');
        }

        // Load next appointment with doctor + notes
        $nextAppointment = Appointment::with([
                'doctor',
                'notes' => fn($q) => $q->orderBy('created_at', 'desc')
            ])
            ->where('patient_id', $patient->id)
            ->whereDate('appointment_date', '>=', now())
            ->orderBy('appointment_date', 'asc')
            ->first();

        $appointmentsCount = Appointment::where('patient_id', $patient->id)->count();

        return view('patient.dashboard', compact('patient', 'nextAppointment', 'appointmentsCount'));
    }

    /**
     * 📅 View all patient appointments
     */
    public function appointments()
{
    // FIX: Always fetch the latest patient record
    $patient = Patient::where('user_id', Auth::id())->latest()->first();

    $appointments = Appointment::with('doctor')
        ->where('patient_id', $patient->id)
        ->orderBy('appointment_date', 'desc')
        ->get();

    return view('patient.appointments.index', compact('appointments'));
}


    /**
     * ➕ Appointment Create Form
     */
    public function createAppointment()
    {
        $doctors = User::where('role', 'doctor')->get();
        return view('patient.appointments.create', compact('doctors'));
    }

    /**
     * 💾 Store Appointment
     */
    public function storeAppointment(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
        ]);

        $patient = Patient::where('user_id', Auth::id())->latest()->first();

        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $validated['doctor_id'],
            'appointment_date' => $validated['appointment_date'],
            'status' => 'pending',
        ]);

        return redirect()->route('patient.appointments')
            ->with('success', 'Your appointment request has been sent successfully.');
    }

    /**
     * 👁️ Appointment Details
     */
   public function showAppointment($id)
{
    // FIX → always use latest patient record
    $patient = Patient::where('user_id', Auth::id())->latest()->first();

    $appointment = Appointment::with(['doctor', 'notes'])
        ->where('id', $id)
        ->where('patient_id', $patient->id)
        ->firstOrFail();

    return view('patient.appointments.show', compact('appointment'));
}


    /**
     * 📄 View Patient Report
     */
    public function report(Patient $patient)
    {
        if ($patient->user_id !== Auth::id()) {
            abort(403);
        }

        $result = json_decode($patient->result, true);
        return view('patient.reports.show', compact('patient', 'result'));
    }

    /**
     * ⬇️ Download Report PDF
     */
    public function downloadReport(Patient $patient)
    {
        if ($patient->user_id !== Auth::id()) {
            abort(403);
        }

        $data = [
            'patient' => $patient,
            'result'  => json_decode($patient->result, true),
        ];

        $pdf = Pdf::loadView('patient.reports.pdf', $data);
        return $pdf->download('Patient_Report_' . $patient->name . '.pdf');
    }

    /**
     * 🧪 Detection Form — Auto-fill user name (NON-editable)
     */
    public function showDetectionForm()
{
    $user = Auth::user();

    // Check if patient already submitted detection data
    $existing = Patient::where('user_id', $user->id)->exists();

    if ($existing) {
        return redirect()->route('patient.dashboard')
            ->with('error', 'Your data is already recorded.');
    }

    return view('patient.detection', compact('user'));
}


    /**
     * 💾 Store Detection + ML Prediction
     */
    public function storeDetection(Request $request)
    {
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

        // Call ML API
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

            $prediction = $response->successful() ? $response->json() : ['status' => 'API Error'];
        } catch (\Exception $e) {
            $prediction = ['status' => 'Pending'];
        }

        // Save in DB
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

        return redirect()->route('patient.dashboard')
    ->with('success', 'Prediction saved successfully!');

    }

    /**
     * ✏ Simple Test Input (no prediction change)
     */
    public function showSimpleTestForm()
    {
        $patient = Patient::where('user_id', Auth::id())->first();

        if (!$patient) {
            return redirect()->route('patient.detection');
        }

        return view('patient.simple_test');
    }

    /**
     * 💾 Update simple test data (keep old prediction)
     */
    public function storeSimpleTest(Request $request)
    {
        $validated = $request->validate([
            'glucose' => 'required|numeric',
            'insulin' => 'required|numeric',
            'bmi' => 'required|numeric',
            'blood_pressure' => 'nullable|numeric',
        ]);

        $patient = Patient::where('user_id', Auth::id())->latest()->first();

        $patient->update([
            'glucose' => $validated['glucose'],
            'insulin' => $validated['insulin'],
            'bmi' => $validated['bmi'],
            'blood_pressure' => $validated['blood_pressure'] ?? null,
        ]);

        return redirect()->route('patient.dashboard')
            ->with('success', 'Your test has been submitted and is under doctor review.');
    }
}
