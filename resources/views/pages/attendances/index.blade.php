@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Attendances</h2>
                        <a class="btn btn-success" href="{{ route('attendances.create') }}">Create New Attendance</a>
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
                                    <th>Event</th>
                                    <th>Is Present</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $attendance)
                                    <tr>
                                        <td>{{ $attendance->id }}</td>
                                        <td>{{ $attendance->user->name }}</td>
                                        <td>{{ $attendance->event->title }}</td>
                                        <td>{{ $attendance->is_present ? 'Yes' : 'No' }}</td>
                                        <td>{{ $attendance->created_at }}</td>
                                        <td>{{ $attendance->updated_at }}</td>
                                        <td>
                                            <a href="{{ route('attendances.edit', $attendance->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('attendances.destroy', $attendance->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this attendance?')">Delete</button>
                                            </form>
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
