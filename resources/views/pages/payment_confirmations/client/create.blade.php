@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{ __('Create Payment Confirmation') }}
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('payment_confirmations.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Field for Registration -->
                    <div class="form-group">
                        <label for="registration_id">{{ __('Registration') }}</label>
                        <select id="registration_id" class="form-control @error('registration_id') is-invalid @enderror" name="registration_id" required>
                            <option value="">Select Registration</option>
                            @foreach ($registrations as $registration)
                                <option value="{{ $registration->id }}" {{ old('registration_id') == $registration->id ? 'selected' : '' }}>{{ $registration->event->title }}</option>
                            @endforeach
                        </select>
                        @error('registration_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Field for Payment Method -->
                    <div class="form-group">
                        <label for="payment_method">{{ __('Payment Method') }}</label>
                        <input id="payment_method" type="text" class="form-control @error('payment_method') is-invalid @enderror" name="payment_method" value="{{ old('payment_method') }}" required autofocus>
                        @error('payment_method')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Field for Amount -->
                    <div class="form-group">
                        <label for="amount">{{ __('Amount') }}</label>
                        <input id="amount" type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}" required>
                        @error('amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Field for Description -->
                    <div class="form-group">
                        <label for="description">{{ __('Description') }}</label>
                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Field for Payment Date -->
                    <div class="form-group">
                        <label for="payment_date">{{ __('Payment Date') }}</label>
                        <input id="payment_date" type="date" class="form-control @error('payment_date') is-invalid @enderror" name="payment_date" value="{{ old('payment_date') }}" required>
                        @error('payment_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Field for Proof Image -->
                    <div class="form-group">
                        <label for="proof_image">{{ __('Proof Image') }}</label>
                        <input id="proof_image" type="file" class="form-control-file @error('proof_image') is-invalid @enderror" name="proof_image">
                        @error('proof_image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
