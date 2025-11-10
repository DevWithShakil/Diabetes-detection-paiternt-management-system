<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Http;

class PatientController extends Controller
{
    public function create()
    {
        return view('create');
    }

    public function predict(Request $request)
    {
        // Send to Python API
        $response = Http::post('http://127.0.0.1:5000/predict', [
            'Pregnancies' => 0,
            'Glucose' => $request->glucose,
            'BloodPressure' => $request->blood_pressure,
            'SkinThickness' => $request->skin_thickness,
            'Insulin' => $request->insulin,
            'BMI' => $request->bmi,
            'DiabetesPedigreeFunction' => $request->diabetes_pedigree,
            'Age' => $request->age,
        ]);

        $data = $response->json();

        // Save in DB
        Patient::create([
            'name' => $request->name,
            'age' => $request->age,
            'glucose' => $request->glucose,
            'blood_pressure' => $request->blood_pressure,
            'skin_thickness' => $request->skin_thickness,
            'insulin' => $request->insulin,
            'bmi' => $request->bmi,
            'diabetes_pedigree' => $request->diabetes_pedigree,
            'result' => json_encode($data)
        ]);

        return view('result', ['data' => $data]);
    }
}

