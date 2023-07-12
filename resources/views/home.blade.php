@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div id="bannerSlider" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    @foreach ($sliders as $slider)
                        <li data-target="#bannerSlider" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    @foreach ($sliders as $slider)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <img src="{{ $slider->banner_slider_image_url }}" alt="{{ $slider->title }}" style="height: 400px; widht: auto !important; margin: auto;" class="d-block">
                        </div>  
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#bannerSlider" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#bannerSlider" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        
        <div class="col-12 mt-5">
            @if (session('status'))
                <div class="card"">
                    <div class="card-body">
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    </div>
                </div>
            @endif

            @guest
            @else
                <div class="row">
                    @foreach($menus as $menu)
                    <div class="col-xl-2 col-md-3 col-sm-4 col-6 my-2">
                        <a href="{{ route($menu->route.'.index') }}" 
                            style="box-shadow: 1px 3px 6px 2px #d5d4d4; height: 100%; text-decoration: unset;" 
                            class="card text-{{ $menu->color }}"
                        >
                            <div class="card-body">
                                <h1 class="card-title text-center">
                                    <i class="{{ $menu->icon }}"></i>
                                </h1>
                                <div class="text-center text-{{ $menu->color }} fw-bold text-capitalize">{{ ucwords(str_replace('_', ' ', $menu->name)) }}</div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

                <div class="pb-5"> </div>
            @endguest


            <h3 class="fw-bold text-secondary">Events</h3>
            <hr class="hr mt-0" />

            <div class="d-flex mb-3">
                @foreach ($categories as $category)
                    <a href="javascript:void(0)" style="border: unset; border-radius: 10px; margin-right: 1rem; text-decoration: none;" class="card">
                        <div class="card-body bg-info" style=" border-radius: 5px; padding: 0.75rem 2rem;">
                            <div class="text-center fw-bold text-white" style="font-size: 14px;">{{ $category->name }}</div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="row">
                @foreach ($events as $event)
                    <div class="col-xl-3 col-md-4 col-sm-6 col-12 mb-3">
                        @include('pages.events.components.card-event')
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </script>
@endsection