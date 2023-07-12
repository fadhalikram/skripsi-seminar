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
    public function index(request $request)
    {
        $categoryID = $request->category_id;

        $user = Auth::user();
        $sliders = Event::where('is_banner_slider', 1)->get();
        if($categoryID) {
            $events = Event::where('category_id', $categoryID)->get();
        } else {
            $events = Event::all();
        }
        $categories = Category::all();
        // $menus = ['events','users','attendances','certificates','categories','registrations'];

        // return $user?->role;
        if($user?->role == 1) {
            $menus = json_decode(json_encode([
                ['route' => 'events', 'name' => 'Event', 'icon' => 'bi bi-calendar-event', 'color' => 'danger'],
                ['route' => 'users', 'name' => 'User', 'icon' => 'bi bi-people', 'color' => 'secondary'],
                ['route' => 'attendances', 'name' => 'Attendance', 'icon' => 'bi bi-person-check-fill', 'color' => 'success'],
                // ['route' => 'certificates', 'name' => 'Certificate', 'icon' => 'bi bi-patch-check', 'color' => 'success'],
                ['route' => 'categories', 'name' => 'Category', 'icon' => 'bi bi-tag', 'color' => 'warning'],
                ['route' => 'registrations', 'name' => 'Registration', 'icon' => 'bi bi-person-lines-fill', 'color' => 'primary'],
                ['route' => 'payment_confirmations', 'name' => 'Payment Confirmation', 'icon' => 'bi bi-check', 'color' => 'info'],
            ]));
        } elseif ($user?->role == 2) {
            $menus = json_decode(json_encode([
                ['route' => 'events.client', 'name' => 'Event', 'icon' => 'bi bi-calendar-event', 'color' => 'danger'],
                ['route' => 'payment_confirmations.client', 'name' => 'Payment Confirmation', 'icon' => 'bi bi-person-lines-fill', 'color' => 'info'],
            ]));
        } else {
            $menus = [];
        }
        
        foreach ($events as $event) {
            $event->banner_image_url = Storage::url($event->banner_image);
            $event->banner_slider_image_url = Storage::url($event->banner_slider_image);
        }
        
        foreach ($sliders as $slider) {
            $slider->banner_image_url = Storage::url($slider->banner_image);
            $slider->banner_slider_image_url = Storage::url($slider->banner_slider_image);
        }
        
        return view('home', compact('events', 'categories', 'menus', 'sliders'));
    }
}
