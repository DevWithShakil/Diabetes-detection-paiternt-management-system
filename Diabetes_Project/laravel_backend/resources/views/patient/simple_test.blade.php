<x-app-layout>
    <x-slot name="header">
        <h2>Add Your Test Data</h2>
    </x-slot>

    <div class="p-6">
        <form method="POST" action="{{ route('patient.simpletest.store') }}">
            @csrf

            <label>Glucose</label>
            <input type="number" name="glucose" required class="mb-3">

            <label>Insulin</label>
            <input type="number" name="insulin" required class="mb-3">

            <label>BMI</label>
            <input type="number" step="any" name="bmi" required class="mb-3">

            <label>Blood Pressure</label>
            <input type="number" step="any" name="blood_pressure" class="mb-3">

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</x-app-layout>
