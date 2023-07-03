@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h3>{{ $title }}s</h3>
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
                                <th>Category</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Location</th>
                                <th>Banner</th>
                                <th>Payment Status</th>
                                <th>Attendance</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($registrations as $registration)
                                <tr>
                                    <td>{{ $registration->event->id }}</td>
                                    <td>{{ $registration->event->category->name }}</td>
                                    <td>{{ $registration->event->title }}</td>
                                    <td>{{ $registration->event->description }}</td>
                                    <td>{{ $registration->event->date }}</td>
                                    <td>{{ $registration->event->time }}</td>
                                    <td>{{ $registration->event->location }}</td>
                                    <td>
                                        <img src="{{ $registration->event->banner_image_url }}" style="max-width: 100px;" alt="Event Image" class="img-fluid">
                                    </td>
                                    <td>{{ $registration->payment_status_name }}</td>
                                    <td>{{ $registration->is_present_name }}</td>
                                    <td>
                                        @if($registration->is_present)
                                            <a href="{{ route('events.certificate.generate', $registration->event->id) }}" target="_blank" class="btn btn-success btn-sm">Download Certificate</a>
                                        @else
                                            <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Download Certificate</a>
                                        @endif
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