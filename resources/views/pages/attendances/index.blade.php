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
                                <span>{{ $message }}</span>
                            </div>
                        @endif
                        <form action="{{ route('attendances.index') }}" method="GET" class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="event_id">Event:</label>
                                    <select class="form-control" id="event_id" name="event_id">
                                        <option value="">Select Event</option>
                                        @foreach ($events as $event)
                                            <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? ' selected' : '' }}>{{ $event->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6" style="display: flex; align-items: end;">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Participant</th>
                                <th>Category</th>
                                <th>Title</th>
                                <th>Date Time</th>
                                <th>Attendance</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($registrations as $registration)
                                <tr>
                                    <td>{{ $registration->event->id }}</td>
                                    <td>{{ $registration->user->name }}</td>
                                    <td>{{ $registration->event->category->name }}</td>
                                    <td>{{ $registration->event->title }}</td>
                                    <td>{{ $registration->event->date }}, {{ $registration->event->time }}</td>
                                    <td>{{ $registration->is_present_name }}</td>
                                    <td>
                                        @if(!$registration->is_present)
                                            <a href="{{ route('attendances.updatePresentStatus', $registration->id) }}"  onclick="return confirm('Are you sure you want to update this attendance?')" class="btn btn-primary btn-sm">{{ __('Persent') }}</a>
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
