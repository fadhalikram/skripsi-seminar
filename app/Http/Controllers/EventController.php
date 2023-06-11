<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        
        foreach ($events as $event) {
            $event->banner_image_url = Storage::url($event->banner_image);
        }
        
        return view('pages.events.index', compact('events'));
    }

    public function create()
    {
        $users = User::all();
        $categories = Category::all();
    
        return view('pages.events.create', compact('users', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'category_id' => 'required',
            'description' => 'nullable',
            'title' => 'required',
            'date' => 'required',
            'time' => 'required',
            'location' => 'required',
            'banner_image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload banner image
        if ($request->hasFile('banner_image')) {
            $imagePath = $request->file('banner_image')->store('banners', 'public');
        } else {
            $imagePath = null;
        }

        // Create the event
        $event = new Event();
        $event->user_id = $request->input('user_id');
        $event->category_id = $request->input('category_id');
        $event->title = $request->input('title');
        $event->description = $request->input('description');
        $event->date = $request->input('date');
        $event->time = $request->input('time');
        $event->location = $request->input('location');
        $event->banner_image = $imagePath;
        $event->save();

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        $users = User::all();
        $categories = Category::all();
        $event->banner_image_url =  Storage::url($event->banner_image);

        return view('pages.events.edit', compact('event', 'users', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'user_id' => 'required',
            'category_id' => 'required',
            'title' => 'required',
            'description' => 'nullable',
            'date' => 'required',
            'time' => 'required',
            'location' => 'required',
            'banner_image' => 'nullable|mimes:jpeg,png,jpg|max:2048',
        ]);


        $imagePath = null;
        if ($request->hasFile('banner_image')) {
            if ($event->banner_image) {
                Storage::disk('public')->delete($event->banner_image);
            }

            $imagePath = $request->file('banner_image')->store('banners', 'public');
            $event->banner_image = $imagePath;
        }
        
        $event->user_id = $request->input('user_id');
        $event->category_id = $request->input('category_id');
        $event->title = $request->input('title');
        $event->description = $request->input('description');
        $event->date = $request->input('date');
        $event->time = $request->input('time');
        $event->location = $request->input('location');
        if($imagePath){
            $event->banner_image = $imagePath;
        }
        $event->save();

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}
