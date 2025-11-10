<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    // Show all doctors with search + pagination
    public function index(Request $request)
    {
        $search = $request->input('search');

        $doctors = Doctor::when($search, function ($query, $search) {
            return $query->where('name', 'ILIKE', "%{$search}%")
                        ->orWhere('email', 'ILIKE', "%{$search}%")
                        ->orWhere('specialization', 'ILIKE', "%{$search}%");
        })
        ->orderBy('id', 'desc')
        ->paginate(5);

        return view('doctors.index', compact('doctors', 'search'));
    }

    // Store new doctor
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email',
            'specialization' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        Doctor::create($request->all());
        return redirect()->route('doctors.index')->with('success', 'Doctor added successfully!');
    }

    // Edit doctor form
    public function edit(Doctor $doctor)
    {
        return view('doctors.edit', compact('doctor'));
    }

    // Update doctor
    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email,' . $doctor->id,
            'specialization' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $doctor->update($request->all());
        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully!');
    }

    // Delete doctor
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully!');
    }

    public function create()
{
    return view('doctors.create');
}

}
