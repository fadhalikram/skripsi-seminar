@extends('layouts.app')

@section('content')
    <div class="bg-secondary text-white" style="margin-top: -1.5rem!important;">
        <div class="container">
            <div class="py-5">
                <div class="row">
                    <div class="col-xl-6 col-12 d-flex align-items-center">
                        <div class="">
                            <h5>
                                <i class="bi bi-award"></i> 
                                Sertifikat
                            </h5>
                            <h2 class="fw-bold">{{ $event->title }}</h2>
                            <h6>9 Peserta Telah Mengikuti Pelatihan Ini</h6>
                        </div>
                    </div>
                    <div class="col-xl-6 col-12">
                        <div class="my-md d-flex justify-content-center">
                            @if ($event->banner_image)
                                <img src="{{ asset($event->banner_image_url) }}" alt="Event Banner" style="height: 250px;" class="img-fluid">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container pt-5">
        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header text-uppercase">
                        Event Details
                    </div>
                    <div class="card-body">
                        <h5 class="text-secondary">Date and Time</h5>
                        <p>{{ $event->date }}, {{ $event->time }}</p>
                        
                        <h5 class="text-secondary">Location</h5>
                        <p>{{ $event->location }}</p>

                        <h5 class="text-secondary">Description</h5>
                        <p>{!! $event->description !!}</p>
                        
                    </div>
                    <!-- <div class="card-footer">
                        <a href="{{ route('events.index') }}" class="btn btn-secondary">Back to Events</a>
                        <a href="{{ route('events.edit', $event->id) }}" class="btn btn-primary">Edit Event</a>
                    </div> -->
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="fw-bold text-secondary">Harga</h5>
                        <h2 class="text-success fw-bold">Rp 200.000</h2>
                        
                        <button class="btn btn-primary btn-lg btn-block w-100 mt-3">Daftar Pelatihan</button>    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
