@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb no-underline">
                <li class="breadcrumb-item"><a href="{{ route('public.home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('events.index') }}">{{ $title }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('events.update', $event->id) }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h3>{{ $title }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @method('PUT')
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"{{ $category->id == $event->category_id ? ' selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ $event->title }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description">{{ $event->description }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="date" name="date" value="{{ $event->date }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="time" class="form-label">Time</label>
                                <input type="time" class="form-control" id="time" name="time" value="{{ $event->time }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control" id="location" name="location" value="{{ $event->location }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="text" class="form-control" id="price" name="price"  value="{{ $event->price }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="banner_image">Banner Image</label>
                                <input type="file" name="banner_image" id="banner_image" class="form-control-file" accept="image/*">
                            </div>

                            @if ($event->banner_image)
                                <div class="mb-3">
                                    <img src="{{ $event->banner_image_url }}" alt="Banner Image" style="max-width: 200px;">
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="is_banner_slider">As Slider Banner:</label>
                                <input type="checkbox" name="is_banner_slider" value="1" id="is_banner_slider" {{  $event->is_banner_slider == '1' ? 'checked' : '' }}>
                            </div>
                            
                            <div class="mb-3 banner-image-input-container" style="display: none;">
                                <label for="banner_slider_image">Banner Slider Image</label>
                                <input type="file" name="banner_slider_image" id="banner_slider_image" class="form-control-file" accept="image/*">
                            </div>

                            @if ($event->banner_slider_image)
                                <div class="mb-3 banner-image-input-container" style="display: none;">
                                    <img src="{{ $event->banner_slider_image_url }}" alt="Banner Image" style="max-width: 200px;">
                                </div>
                            @endif
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            
            var event = <?php echo json_encode($event); ?>;
            var isSliderBanner = event['is_banner_slider'];

            if(isSliderBanner == 1){
                $('.banner-image-input-container').show();
            }
            
            $('#is_banner_slider').change(function() {
                if ($(this).is(':checked')) {
                    $('.banner-image-input-container').show();
                } else {
                    $('.banner-image-input-container').hide();
                }
            });
        });
    </script>
@endsection