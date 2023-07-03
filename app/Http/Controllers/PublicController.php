<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;
use App\Models\Registration;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $events = Event::all();
        $categories = Category::all();
        
        foreach ($events as $event) {
            $event->banner_image_url = Storage::url($event->banner_image);
        }
        
        return view('home', compact('events', 'categories'));
    }
    

    public function showEvent($id)
    {
        
        // Cek apakah seminar ada
        $event = Event::find($id);
        if(!$event) return view('home');
        
        $event->banner_image_url = Storage::url($event->banner_image);
        $event->can_register = $event->date > now();
        
        // Cek apakah user sudah terdaftar pada seminar ini
        $user = Auth::user();
        $registration = Registration::where('user_id', $user?->id)->where('event_id', $event->id)->first();
        $event->has_registered = !!$registration;
        
        // Menghitung peserta yang terdaftar pada seminar ini
        $registrationCount = Registration::where('event_id', $event->id)->count();
        $event->count_registered = $registrationCount;

        return view('pages.events.public-show', compact('event'));
    }
}
