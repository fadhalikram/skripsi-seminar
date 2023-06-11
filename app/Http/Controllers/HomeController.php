<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
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
        // $menus = ['events','users','attendances','certificates','categories','registrations'];
        $menus = json_decode(json_encode([
            ['name' => 'events', 'icon' => 'bi bi-calendar-event', 'color' => 'success'],
            ['name' => 'users', 'icon' => 'bi bi-people', 'color' => 'success'],
            ['name' => 'attendances', 'icon' => 'bi bi-person-check-fill', 'color' => 'success'],
            ['name' => 'certificates', 'icon' => 'bi bi-patch-check', 'color' => 'success'],
            ['name' => 'categories', 'icon' => 'bi bi-tag', 'color' => 'success'],
            ['name' => 'registrations', 'icon' => 'bi bi-person-lines-fill', 'color' => 'success'],
        ]));
        
        foreach ($events as $event) {
            $event->banner_image_url = Storage::url($event->banner_image);
        }
        
        return view('home', compact('events', 'categories', 'menus'));
    }
}
