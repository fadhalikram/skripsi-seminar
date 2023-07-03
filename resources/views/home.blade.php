@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div id="bannerSlider" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    @foreach ($events as $event)
                        <li data-target="#bannerSlider" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    @foreach ($events as $event)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <!-- <img src="{{ $event->banner_image_url }}" alt="{{ $event->title }}" class="d-block w-100"> -->
                            <img src="https://cdn1.codashop.com/S/content/common/images/promos/June23/ID_CODM-Doublewing-Draw-Bonus-Garena-Shells-33_06-06-2023.jpg" alt="{{ $event->title }}" class="d-block w-100">
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
                <div class="card">
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
                    <div class="col-xl-2 col-md-3 col-sm-4 col-6 my-1">
                        <a href="{{ route($menu->route.'.index') }}" class="card text-{{ $menu->color }} border-{{ $menu->color }}  no-underline">
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


            <h3 class="fw-bold text-secondary">Categories</h3>
            <hr class="hr" />

            <div class="row">
                @foreach ($categories as $category)
                    <div class="col-xl-2 col-md-3 col-sm-4 col-6">
                        <a href="javascript:void(0)" class="card  no-underline">
                            <div class="card-body">
                                <div class="text-center fw-bold text-uppercase">{{ $category->name }}</div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="pb-5"> </div>

            <h3 class="fw-bold text-secondary">Events</h3>
            <hr class="hr" />

            <div class="row">
                @foreach ($events as $event)
                    <div class="col-xl-3 col-md-4 col-sm-6 col-12">
                        <a href="{{ route('public.event.show', $event->id) }}" class="card my-2 no-underline">
                            <img src="{{$event->banner_image_url}}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-secondary pb-3">{{ $event->title }}</h5>
                                <h4 class="fw-bold">Rp 200.000</h4>
                                <div class="text-warning">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    &nbsp;
                                    <span class="text-secondary">(1 Rating)</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Inisialisasi slider banner
            $('#bannerSlider').carousel();
        });
    </script>
@endsection