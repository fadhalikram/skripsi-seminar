@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Registrations</h2>
                        <a class="btn btn-success" href="{{ route('registrations.create') }}">Create New Registration</a>
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
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($registrations as $registration)
                                    <tr>
                                        <td>{{ $registration->id }}</td>
                                        <td>{{ $registration->user->name }}</td>
                                        <td>{{ $registration->event->title }}</td>
                                        <td>{{ $registration->created_at }}</td>
                                        <td>{{ $registration->updated_at }}</td>
                                        <td>
                                            <a href="{{ route('registrations.edit', $registration->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('registrations.destroy', $registration->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this registration?')">Delete</button>
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
