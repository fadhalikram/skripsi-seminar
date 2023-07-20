@extends('layouts.app')

@section('content')
    @php
        use Carbon\Carbon;
    @endphp

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb no-underline">
                <li class="breadcrumb-item"><a href="{{ route('public.home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="mb-0">{{ $title }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif

                        <h4>Jumlah Seminar per Bulan</h4>
                        <ul>
                            @foreach ($eventsPerMonth as $event)
                                <li><strong>{{ $event->total }}</strong> seminar pada {{ Carbon::parse($event->month)->isoFormat('MMMM YYYY') }}</li>
                            @endforeach
                        </ul>

                        <!-- Tampilkan jumlah peserta berdasarkan event -->
                        <h4>Jumlah Peserta per Event</h4>
                        <ul>
                            @foreach ($participantsPerEvent as $event)
                                <li><strong>{{ $event->total }} peserta</strong> pada seminar {{ $event->title}}</li>
                            @endforeach
                        </ul>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
