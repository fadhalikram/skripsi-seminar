
<a href="{{ route('public.event.show', $event->id) }}" class="card h-100" style="box-shadow: 1px 8px 8px 4px #d5d4d4; text-decoration: unset!important;">
    <div style="height: 200px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
        <img src="{{$event->banner_image_url}}" class="card-img-top" style="height: auto; width: 100%;" alt="...">
    </div>
    <div class="card-body">
        <h5 class="card-title fw-bold text-secondary pb-3" style="height: 100px;">{{ $event->title }}</h5>
        @if($event->price == 0)
            <h4 class="fw-bold text-success">Free</h4>
        @else
            <h4 class="fw-bold">Rp {{ number_format($event->price) }}</h4>
        @endif
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