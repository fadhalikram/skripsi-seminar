@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb no-underline">
                <li class="breadcrumb-item"><a href="{{ route('public.home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('registrations.index') }}">{{ $title }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="{{ route('registrations.update', $registration->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="mb-0">{{ $title }}</h5>
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

                            <div class="form-group">
                                <label for="user_id">User</label>
                                <select id="user_id" class="form-control @error('user_id') is-invalid @enderror" name="user_id" required>
                                    <option value="">Select User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ $registration->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="event_id">Event</label>
                                <select id="event_id" class="form-control @error('event_id') is-invalid @enderror" name="event_id" required>
                                    <option value="">Select Event</option>
                                    @foreach ($events as $event)
                                        <option value="{{ $event->id }}" {{ $registration->event_id == $event->id ? 'selected' : '' }}>{{ $event->title }}</option>
                                    @endforeach
                                </select>
                                @error('event_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
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
