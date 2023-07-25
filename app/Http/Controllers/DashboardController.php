<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Category;


class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(request $request)
    {
        $title = "Dashboard";
        $categories = Category::get();

        $categoryId = $request->input('category_id');
        $dateStart = $request->input('date_start');
        $dateEnd = $request->input('date_end');

        // Menghitung jumlah event per periode (1 bulan terakhir)
        $queryEventsPerMonth = DB::table('events')
            ->select(DB::raw('DATE_FORMAT(events.date, "%Y-%m") as month'), DB::raw('count(*) as total'))
            ->leftJoin('registrations', 'events.id', '=', 'registrations.event_id')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->take(12); 
            
        // Menghitung jumlah peserta berdasarkan event
        $queryParticipantsPerEvent = DB::table('events')
            ->select(
                'events.id', 
                'events.title', 
                'events.date', 
                'events.category_id as category_id',
                'certificates.word_speaker as speaker',
                'categories.name as category_name',
                DB::raw('count(registrations.id) as total')
            )
            ->leftJoin('registrations', 'events.id', '=', 'registrations.event_id')
            ->leftJoin('certificates', 'events.id', '=', 'certificates.event_id')
            ->leftJoin('categories', 'events.category_id', '=', 'categories.id')
            ->groupBy(
                'events.id', 
                'events.title', 
                'certificates.word_speaker', 
                'categories.name', 
                'events.category_id',
                'events.date'
            )
            ->orderBy('events.date', 'desc');
        // return $queryParticipantsPerEvent->get();

        if($categoryId !== null) {
            $queryEventsPerMonth->where('events.category_id', $categoryId);
            $queryParticipantsPerEvent->where('events.category_id', $categoryId);
        }
        
        if ($dateStart !== null && $dateEnd !== null) {
            $queryEventsPerMonth->where('events.date', ">=", $dateStart)->where('events.date', "<=",$dateEnd);
            $queryParticipantsPerEvent->where('events.date', ">=", $dateStart)->where('events.date', "<=",$dateEnd);
        } else {
            if($dateStart !== null) {
                $queryEventsPerMonth->where('events.date', $dateStart);
                $queryParticipantsPerEvent->where('events.date', $dateStart);
            } else if ($dateEnd !== null) {
                $queryEventsPerMonth->where('events.date', $dateEnd);
                $queryParticipantsPerEvent->where('events.date', $dateEnd);
            } 
        }
        
        $eventsPerMonth = $queryEventsPerMonth->get();
        $participantsPerEvent = $queryParticipantsPerEvent->get();
        // return $participantsPerEvent;

        return view('pages.dashboard.index', compact('title', 'eventsPerMonth', 'participantsPerEvent', 'categories'));
    }
}