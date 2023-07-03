<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RegistrationController extends Controller
{
    protected $title = 'Registration';

    public function index(Request $request)
    {
        $title = $this->title;

        $user = Auth::user();
        $events = Event::all();
        
        // Filters
        $eventId = $request->input('event_id');

        $query = Registration::query();

        if ($eventId !== null) {
            $query->where('event_id', $eventId);
        }
    
        $registrations = $query->with('event.certificate', 'user')->get();
       
        foreach ($registrations as $registration) {
            $registration->event->banner_image_url = Storage::url($registration->event->banner_image);
            $registration->payment_status_name = $registration->payment_status == 0 ? 'Confirmation Process' : 'Paid';
        }
        
        return view('pages.registrations.index', compact('title', 'registrations', 'events'));
    }

    public function create()
    {
        $title = $this->title;
        $users = User::all();
        $events = Event::all();

        return view('pages.registrations.create', compact('title', 'users', 'events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'event_id' => 'required',
        ]);

        Registration::create($request->all());
        return redirect()->route('registrations.index')->with('success', 'Registration created successfully.');
    }

    public function edit(Registration $registration)
    {
        $title = $this->title;
        return view('pages.registrations.edit', compact('title', 'registration'));
    }

    public function update(Request $request, Registration $registration)
    {
        $request->validate([
            'user_id' => 'required',
            'event_id' => 'required',
        ]);

        $registration->update($request->all());
        return redirect()->route('registrations.index')->with('success', 'Registration updated successfully.');
    }

    public function destroy(Registration $registration)
    {
        $registration->delete();
        return redirect()->route('registrations.index')->with('success', 'Registration deleted successfully.');
    }

    public function eventRegister(Request $request, $id)
    {
        $event = Event::find($id);
        if(!$event) return redirect()->back()->with('failed', 'Seminar tidak ditemukan');
        if($event->date < now()) return redirect()->back()->with('failed', 'Seminar sudah tidak tersedia dan telah berlangsung pada ' . $event->date);
        
        $user = Auth::User();
        $registration = new Registration();
        $registration->user_id = $user->id;
        $registration->event_id = $id;
        $registration->save();
        
        return redirect()->back()->with('success', 'Anda telah terdaftar sebagai peserta pada seminar ini');
    }
}
