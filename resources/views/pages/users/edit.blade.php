@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb no-underline">
                <li class="breadcrumb-item text-success"><a href="{{ route('public.home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ $title }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Edit {{ $title }}</h5>
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
                        <form action="{{ route('users.update', $user) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required />
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required />
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select id="role" class="form-control @error('role') is-invalid @enderror" name="role">
                                    <option value="1" {{ old('role') == "1" ? 'selected' : '' }}>Admin</option>
                                    <option value="2" {{ old('role') == "2" ? 'selected' : '' }}>Participant</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="password">New Password:</label>
                                <input type="password" class="form-control" id="password" name="password" />
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
