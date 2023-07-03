@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Certificates</h2>
                        <a class="btn btn-success" href="{{ route('certificates.create') }}">Create New Certificate</a>
                    </div>
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif

                        <table class="table table-bordered">
                            <tr>
                                <th>No</th>
                                <th>User</th>
                                <th>Event</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($certificates as $certificate)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $certificate->user->name }}</td>
                                    <td>{{ $certificate->event->title }}</td>
                                    <td>
                                        <form action="{{ route('certificates.destroy', $certificate->id) }}" method="POST">
                                            <a class="btn btn-primary" href="{{ route('certificates.edit', $certificate->id) }}">Edit</a>

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
