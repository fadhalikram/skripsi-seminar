@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb no-underline">
                <li class="breadcrumb-item"><a href="{{ route('public.home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="mb-0 mt-2">{{ $title }}s</h5>
                            </div>
                            <div class="col-6 text-end">
                                <a class="btn btn-success" href="{{ route('events.create') }}">Create New {{$title}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif

                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Category</th>
                                <th>Title</th>
                                <th>Speaker</th>
                                <th>Description</th>
                                <th>Date Time</th>
                                <th>Price</th>
                                <th>Location</th>
                                <th>Banner</th>
                                <th>Slider</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($events as $event)
                                <tr>
                                    <td>{{ $event->id }}</td>
                                    <td>{{ $event->user->name }}</td>
                                    <td>{{ $event->category->name }}</td>
                                    <td>{{ $event->title }}</td>
                                    <td>{{ $event->speaker }}</td>
                                    <td>{!! nl2br($event->description) !!}</td>
                                    <td>{{ $event->date }}, {{ $event->time }}</td>
                                    <td>
                                        {{ 'Rp ' . number_format($event->price, 0, ',', '.') }}
                                    <td>
                                        <a href="{{ $event->location }}">Lihat</a>
                                    </td>
                                    <td>
                                        <img src="{{ $event->banner_image_url }}" style="max-width: 100px;" alt="Event Image" class="img-fluid">
                                    </td>
                                    <td>
                                        @if($event->is_banner_slider)
                                            <img src="{{ $event->banner_slider_image_url }}" style="max-width: 100px;" alt="Event Image" class="img-fluid">
                                        @else
                                            <span class="text-secondary">unset</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('events.edit', $event->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                        <a href="{{ route('events.certificate.upsert', $event->id) }}" class="btn btn-{{$event->certificate ? 'success' : 'warning'}} btn-sm">Certificate</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection