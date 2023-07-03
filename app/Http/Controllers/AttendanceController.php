<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Registration;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    protected $title = 'Attendance';

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
            $registration->is_present_name = !$registration->is_present ? 'Not Present' : 'Present';
        }
        
        return view('pages.attendances.index', compact('title', 'registrations', 'events'));
    }

    public function updatePresentStatus(Registration $registration)
    {
        $registration->is_present = true;
        $registration->save();

        return redirect()->back()->with('success', 'Attendance status updated successfully.');
    }
}
