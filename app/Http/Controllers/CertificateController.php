<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::all();
        return view('pages.certificates.index', compact('certificates'));
    }

    public function create()
    {
        $users = User::all();
        $events = Event::all();
    
        return view('pages.certificates.create', compact('users', 'events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'event_id' => 'required',
            'file_path' => 'required',
        ]);

        Certificate::create($request->all());

        return redirect()->route('certificates.index')->with('success', 'Certificate created successfully.');
    }

    public function edit(Certificate $certificate)
    {
        $users = User::all();
        $events = Event::all();

        return view('pages.certificates.edit', compact('certificate', 'users', 'events'));
    }

    public function update(Request $request, Certificate $certificate)
    {
        $request->validate([
            'user_id' => 'required',
            'event_id' => 'required',
            'file_path' => 'required',
        ]);

        $certificate->update($request->all());

        return redirect()->route('certificates.index')->with('success', 'Certificate updated successfully.');
    }

    public function destroy(Certificate $certificate)
    {
        $certificate->delete();

        return redirect()->route('certificates.index')->with('success', 'Certificate deleted successfully.');
    }
}
