@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="{{ route('attendances.update', $attendance->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <h2>Edit attendance</h2>
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
                                <input id="user_id" type="number" class="form-control @error('user_id') is-invalid @enderror" name="user_id" value="{{ $attendance->user_id }}" required autofocus>
                                @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="event_id">Event</label>
                                <input id="event_id" type="number" class="form-control @error('event_id') is-invalid @enderror" name="event_id" value="{{ $attendance->event_id }}" required>
                                @error('event_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="is_present">Is Present</label>
                                <select id="is_present" class="form-control @error('is_present') is-invalid @enderror" name="is_present">
                                    <option value="0" {{ $attendance->is_present == 0 ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ $attendance->is_present == 1 ? 'selected' : '' }}>Yes</option>
                                </select>
                                @error('is_present')
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
