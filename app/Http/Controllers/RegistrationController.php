<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index()
    {
        $registrations = Registration::all();
        return view('pages.registrations.index', compact('registrations'));
    }

    public function create()
    {
        return view('pages.registrations.create');
    }

    public function store(RegistrationRequest $request)
    {
        Registration::create($request->validated());
        return redirect()->route('registrations.index')->with('success', 'Registration created successfully.');
    }

    public function edit(Registration $registration)
    {
        return view('pages.registrations.edit', compact('registration'));
    }

    public function update(RegistrationRequest $request, Registration $registration)
    {
        $registration->update($request->validated());
        return redirect()->route('registrations.index')->with('success', 'Registration updated successfully.');
    }

    public function destroy(Registration $registration)
    {
        $registration->delete();
        return redirect()->route('registrations.index')->with('success', 'Registration deleted successfully.');
    }
}
