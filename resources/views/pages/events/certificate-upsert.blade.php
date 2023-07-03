@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('events.certificate.submitUpsert', $event->id) }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h3>{{ $certificate?->id ? 'Edit' : 'Create' }} Certificate</h3>
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
                            
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <span>{{ $message }}</span>
                                </div>
                            @endif

                                <div class="mb-3">
                                    <label for="word_title" class="form-label">Word of Title</label>
                                    <input type="text" class="form-control" id="word_title" name="word_title" value="{{ $certificate?->word_title }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="word_desc" class="form-label">Wokrd of Description</label>
                                    <textarea class="form-control" id="word_desc" name="word_desc">{{ $certificate?->word_desc }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="word_organization" class="form-label">Word of Organization</label>
                                    <textarea class="form-control" id="word_organization" name="word_organization">{{ $certificate?->word_organization }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="word_speaker" class="form-label">Word of Speaker</label>
                                    <textarea class="form-control" id="word_speaker" name="word_speaker">{{ $certificate?->word_speaker }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="certificate_number" class="form-label">Number of Certificate</label>
                                    <textarea class="form-control" id="certificate_number" name="certificate_number">{{ $certificate?->certificate_number }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="logo_image">Logo Image</label>
                                    <input type="file" name="logo_image" id="logo_image" class="form-control-file" accept="image/*">
                                </div>

                                @if ($certificate?->logo_image)
                                    <div class="mb-3">
                                        <img src="{{ $certificate?->logo_image_url }}" alt="Banner Image" style="max-width: 200px;">
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label for="signature_image">Signature Image</label>
                                    <input type="file" name="signature_image" id="signature_image" class="form-control-file" accept="image/*">
                                </div>

                                @if ($certificate?->signature_image)
                                    <div class="mb-3">
                                        <img src="{{ $certificate?->signature_image_url }}" alt="Banner Image" style="max-width: 200px;">
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label for="background_image">Background Image</label>
                                    <input type="file" name="background_image" id="background_image" class="form-control-file" accept="image/*">
                                </div>

                                @if ($certificate?->background_image)
                                    <div class="mb-3">
                                        <img src="{{ $certificate?->background_image_url }}" alt="Banner Image" style="max-width: 200px;">
                                    </div>
                                @endif

                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ route('events.certificate.generate', $event->id) }}" target="_blank" class="btn btn-info text-white">Preview</a>
                            <button type="submit" class="btn btn-primary">{{ $certificate?->id ? 'Update' : 'Create' }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
