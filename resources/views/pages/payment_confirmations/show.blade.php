@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{ __('Payment Confirmation Details') }}
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>{{ __('Event') }}</th>
                        <td>{{ $registration->event->title }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('Payment Method') }}</th>
                        <td>{{ $paymentConfirmation->payment_method }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('Amount') }}</th>
                        <td>{{ 'Rp ' . number_format($registration->paymentConfirmation->amount, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('Description') }}</th>
                        <td>{{ $paymentConfirmation->description }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('Payment Date') }}</th>
                        <td>{{ $paymentConfirmation->payment_date }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('Payment Status') }}</th>
                        <td>
                            <span class="text-{{ $registration->payment_status == 1 ? 'success' : 'warning'}}">
                                {{ $registration->payment_status_name }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>{{ __('Proof Image') }}</th>
                        <td>
                            @if ($paymentConfirmation->proof_image)
                                <img src="{{ asset('storage/' . $paymentConfirmation->proof_image) }}" alt="{{ __('Proof Image') }}" style="max-width: 200px">
                            @else
                                {{ __('No Proof Image') }}
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            @if($registration->payment_status == 0)
                <div class="card-footer text-center">
                    <a href="{{ route('payment_confirmations.updatePaymentStatus', $paymentConfirmation->id) }}"  onclick="return confirm('Are you sure you want to approve this payment?')" class="btn btn-primary">{{ __('Approve') }}</a>
                </div>
            @endif
        </div>
    </div>
@endsection
