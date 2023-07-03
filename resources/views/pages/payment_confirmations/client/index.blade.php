@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="col-md-12">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3>{{ $title }}s</h3>
                        </div>
                        <div class="col-6 text-end">
                            <a class="btn btn-success" href="{{ route('payment_confirmations.client.create') }}">Create New {{ $title }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('Event') }}</th>
                            <th scope="col">{{ __('Payment Method') }}</th>
                            <th scope="col">{{ __('Amount') }}</th>
                            <th scope="col">{{ __('Payment Date') }}</th>
                            <th scope="col">{{ __('Payment Status') }}</th>
                            <th scope="col">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($registrations as $registration)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $registration->event->title }}</td>
                                <td>{{ $registration->paymentConfirmation->payment_method }}</td>
                                <td>
                                    {{ 'Rp ' . number_format($registration->paymentConfirmation->amount, 0, ',', '.') }}
                                </td>
                                <td>{{ $registration->paymentConfirmation->payment_date }}</td>
                                <td>
                                    <span class="text-{{ $registration->payment_status == 1 ? 'success' : 'warning'}}">
                                        {{ $registration->payment_status_name }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('payment_confirmations.client.show', $registration->paymentConfirmation->id) }}" class="btn btn-primary btn-sm">{{ __('View') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
