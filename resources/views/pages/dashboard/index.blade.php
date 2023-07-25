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
                                <h5 class="mb-0">Event Summary</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        
                        <form action="{{ route('dashboard.index') }}" method="GET" class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="category_id">Category:</label>
                                    <select class="form-control" id="category_id" name="category_id">
                                        <option value="">Select Event</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? ' selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="category_id">Date Start:</label>
                                    <input type="date" name="date_start" value="{{ request('date_start') }}" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="category_id">Date End:</label>
                                    <input type="date" name="date_end" value="{{ request('date_end') }}" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-3" style="display: flex; align-items: end;">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </form>

                        <hr />

                        <div>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Category</th>
                                    <th>Event</th>
                                    <th>Participant</th>
                                    <th>Speaker</th>
                                    <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if($participantsPerEvent->count() > 0)
                                        @foreach($participantsPerEvent as $event)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $event->category_name }}</td>
                                                <td>{{ $event->title }}</td>
                                                <td>{{ $event->total }}</td>
                                                <td>{{ $event->speaker }}</td>
                                                <td>{{ $event->date }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center text-secondary">Event not found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card mt-3">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="mb-0">Number of Seminars per Month</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Month</th>
                                <th>Event Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($eventsPerMonth as $event)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ Carbon::parse($event->month)->isoFormat('MMMM YYYY') }}</td>
                                    <td>{{ $event->total }}</td>
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
