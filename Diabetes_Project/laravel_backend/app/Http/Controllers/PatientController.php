<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\ModelStat;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\PredictionMail;

class PatientController extends Controller
{
    public function index(Request $req) {
        $q = Patient::query();
        if ($req->filled('q')) {
            $q->where('name','ilike','%'.$req->q.'%');
        }
        $patients = $q->orderBy('created_at','desc')->paginate(15);
        return view('patients.index', compact('patients'));
    }

    public function create(){ return view('patients.create'); }

    public function store(Request $r){
        $data = $r->validate([
            'name'=>'required',
            'age'=>'required|integer',
            'glucose'=>'required|numeric',
            'blood_pressure'=>'required|numeric',
            'skin_thickness'=>'required|numeric',
            'insulin'=>'required|numeric',
            'bmi'=>'required|numeric',
            'diabetes_pedigree'=>'required|numeric'
        ]);

        // Call ML API (select models param optional)
        $response = Http::timeout(120)->post(config('services.ml.url').'/predict', [
            'Pregnancies' => $r->input('pregnancies',0),
            'Glucose' => $data['glucose'],
            'BloodPressure' => $data['blood_pressure'],
            'SkinThickness' => $data['skin_thickness'],
            'Insulin' => $data['insulin'],
            'BMI' => $data['bmi'],
            'DiabetesPedigreeFunction' => $data['diabetes_pedigree'],
            'Age' => $data['age'],
            'models' => $r->input('models', []) // optional list
        ]);

        $json = $response->json();

        $patient = Patient::create(array_merge($data, ['result' => $json]));

        // update model stats (simple)
        if (isset($json['accuracies'])){
            foreach($json['accuracies'] as $model => $acc){
                $m = ModelStat::firstOrCreate(['model_name'=>$model]);
                $m->accuracy = $acc;
                $m->runs = $m->runs + 1;
                $m->save();
            }
        }

        // Optional: if majority of models say Diabetic -> send mail
        $preds = $json['predictions'] ?? [];
        $diabeticCount = collect($preds)->filter(fn($v)=>$v==='Diabetic')->count();
        if ($diabeticCount >= ceil(count($preds)/2)) {
            // send email (patient must have email field if you want) — sample
            // Mail::to('patient@example.com')->send(new PredictionMail($patient));
        }

        return redirect()->route('patients.show', $patient)->with('success','Prediction saved.');
    }

    public function show(Patient $patient) {
        return view('patients.show', compact('patient'));
    }

    public function downloadReport(Patient $patient) {
        $pdf = Pdf::loadView('patients.pdf', compact('patient'));
        return $pdf->download('report-'.$patient->id.'.pdf');
    }

    public function destroy(Patient $patient){
        $patient->delete();
        return redirect()->route('patients.index')->with('success','Deleted');
    }
}
