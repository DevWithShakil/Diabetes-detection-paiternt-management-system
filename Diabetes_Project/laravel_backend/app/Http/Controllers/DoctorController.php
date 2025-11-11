<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
}
