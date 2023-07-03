<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $events = Event::all();
        $categories = Category::all();
        // $menus = ['events','users','attendances','certificates','categories','registrations'];

        // return $user?->role;
        if($user?->role == 1) {
            $menus = json_decode(json_encode([
                ['route' => 'events', 'name' => 'Event', 'icon' => 'bi bi-calendar-event', 'color' => 'success'],
                ['route' => 'users', 'name' => 'User', 'icon' => 'bi bi-people', 'color' => 'success'],
                ['route' => 'attendances', 'name' => 'Attendance', 'icon' => 'bi bi-person-check-fill', 'color' => 'success'],
                // ['route' => 'certificates', 'name' => 'Certificate', 'icon' => 'bi bi-patch-check', 'color' => 'success'],
                ['route' => 'categories', 'name' => 'Category', 'icon' => 'bi bi-tag', 'color' => 'success'],
                ['route' => 'registrations', 'name' => 'Registration', 'icon' => 'bi bi-person-lines-fill', 'color' => 'success'],
                ['route' => 'payment_confirmations', 'name' => 'Payment Confirmation', 'icon' => 'bi bi-person-lines-fill', 'color' => 'success'],
            ]));
        } elseif ($user?->role == 2) {
            $menus = json_decode(json_encode([
                ['route' => 'events.client', 'name' => 'Event', 'icon' => 'bi bi-calendar-event', 'color' => 'success'],
                ['route' => 'payment_confirmations.client', 'name' => 'Payment Confirmation', 'icon' => 'bi bi-person-lines-fill', 'color' => 'success'],
            ]));
        } else {
            $menus = [];
        }
        
        foreach ($events as $event) {
            $event->banner_image_url = Storage::url($event->banner_image);
        }
        
        return view('home', compact('events', 'categories', 'menus'));
    }
}
