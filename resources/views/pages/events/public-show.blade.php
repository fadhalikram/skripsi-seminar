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
                            <h6>{{ $event->count_registered }} Peserta Telah Mengikuti Pelatihan Ini</h6>
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
                
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <span>{{ $message }}</span>
                    </div>
                @endif
                
                @if ($message = Session::get('failed'))
                    <div class="alert alert-danger">
                        <span>{{ $message }}</span>
                    </div>
                @endif

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
                        <div>{!! nl2br($event->description) !!}</div>
                        
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
                        <h2 class="text-success fw-bold">{{ $event->price == 0 ? 'Free' : "Rp " . number_format($event->price) }}</h2>
                        
                        @if($event->can_register)
                            @if(!$event->has_registered)
                                <a href="{{ route('events.eventRegister', $event->id) }}" class="btn btn-primary btn-lg btn-block w-100 mt-3">
                                    Daftar Pelatihan
                                </a>
                            @else
                                <a href="javascript:void(0)" class="btn btn-success btn-lg btn-block w-100 mt-3">
                                    Telah Terdaftar
                                </a>    
                            @endif    
                        @else
                            <a href="javascript:void(0)" class="btn btn-secondary btn-lg btn-block w-100 mt-3">
                                <i class="bi bi-lock"></i> 
                                Tidak Tersedia
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
