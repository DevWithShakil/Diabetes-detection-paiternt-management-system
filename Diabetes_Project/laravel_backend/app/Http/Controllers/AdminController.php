<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Patient;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:admin']);
    }

    public function index()
    {
        $user = Auth::user();

        // 🔹 Dashboard Stats
        $totalPatients = Patient::count();
        $totalDoctors = User::where('role', 'doctor')->count();
        $totalPredictions = Patient::whereNotNull('result')->count();

        // 🔹 Default chart labels
        $chartData = [
            'Decision Tree' => 0,
            'KNN' => 0,
            'Logistic Regression' => 0,
            'Random Forest' => 0,
            'SVM' => 0,
        ];

        // 🔹 Fetch last prediction record (latest patient)
        $latestPatient = Patient::latest()->first();

        if ($latestPatient) {
            $result = json_decode($latestPatient->result, true);

            // Check if accuracies exist in result JSON
            if (isset($result['accuracies']) && is_array($result['accuracies'])) {
                foreach ($result['accuracies'] as $model => $accuracy) {
                    $chartData[$model] = round($accuracy, 2);
                }
            }
        }

        // 🔹 Get last 10 patients for table
        $patients = Patient::latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'user',
            'totalPatients',
            'totalDoctors',
            'totalPredictions',
            'chartData',
            'patients'
        ));
    }

    // ✅ PDF Download for specific patient
    public function downloadReport(Patient $patient)
    {
        $pdf = Pdf::loadView('patients.report', compact('patient'));
        return $pdf->download('report-' . $patient->id . '.pdf');
    }
}
