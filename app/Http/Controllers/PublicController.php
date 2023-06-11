<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

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
        $event = Event::find($id);
        $event->banner_image_url =  Storage::url($event->banner_image);

        return view('pages.events.public-show', compact('event'));
    }
}
