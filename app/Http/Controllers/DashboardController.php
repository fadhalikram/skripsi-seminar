<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        // Menghitung jumlah event per periode (1 bulan terakhir)
        $eventsPerMonth = DB::table('events')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as total'))
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->take(12) // Ambil data 12 bulan terakhir
            ->get();

        // Menghitung jumlah peserta berdasarkan event
        $participantsPerEvent = DB::table('events')
            ->join('registrations', 'events.id', '=', 'registrations.event_id')
            ->select('events.title', DB::raw('count(registrations.id) as total'))
            ->groupBy('events.title')
            ->get();

        return view('pages.dashboard.index', compact('title', 'eventsPerMonth', 'participantsPerEvent'));
    }
}