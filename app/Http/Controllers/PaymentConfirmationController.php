<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentConfirmation;
use App\Models\Registration;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class PaymentConfirmationController extends Controller
{
    protected $title = 'Payment Confirmation';

    public function create()
    {
        $title = $this->title;
        $registrations = Registration::all();
        return view('pages.payment_confirmations.create', compact('title', 'registrations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'registration_id' => 'required',
            'payment_method' => 'required',
            'amount' => 'required',
            'payment_date' => 'required',
        ]);

        $paymentConfirmation = PaymentConfirmation::create($request->all());

        if ($request->hasFile('proof_image')) {
            $proofImage = $request->file('proof_image')->store('payment_confirmations', 'public');
            $paymentConfirmation->proof_image = $proofImage;
            $paymentConfirmation->save();
        }

        return redirect()->route('payment_confirmations.index')->with('success', 'Payment confirmation created successfully.');
    }

    public function index()
    {
        $title = $this->title;
        $registrations = Registration::with('paymentConfirmation', 'event')->has('paymentConfirmation')->get();
        
        foreach ($registrations as $registration) {
            $registration->payment_status_name = $registration->payment_status == 0 ? 'Confirmation Process' : 'Paid';
        }

        return view('pages.payment_confirmations.index', compact('registrations', 'title'));
    }

    public function show(PaymentConfirmation $paymentConfirmation)
    {
        $title = $this->title;
        $registration = Registration::where('id', $paymentConfirmation->registration->id)->with('event')->first();
        $registration->payment_status_name = $registration->payment_status == 0 ? 'Confirmation Process' : 'Paid';
        return view('pages.payment_confirmations.show', compact('title', 'paymentConfirmation', 'registration'));
    }
    
    public function updatePaymentStatus(PaymentConfirmation $paymentConfirmation)
    {
        $registration = Registration::where('id', $paymentConfirmation->id)->first();
        $registration->payment_status = 1;
        $registration->save();

        return redirect()->route('payment_confirmations.index')->with('success', 'Payment confirmation status updated successfully.');
    }
    
    // public function edit(PaymentConfirmation $paymentConfirmation)
    // {
    //     $registrations = Registration::all();
    //     return view('pages.payment_confirmations.edit', compact('paymentConfirmation', 'registrations'));
    // }

    // public function update(Request $request, PaymentConfirmation $paymentConfirmation)
    // {
    //     $request->validate([
    //         'registration_id' => 'required',
    //         'payment_method' => 'required',
    //         'amount' => 'required',
    //         'payment_date' => 'required',
    //     ]);

    //     $paymentConfirmation->update($request->all());

    //     if ($request->hasFile('proof_image')) {
    //         $proofImage = $request->file('proof_image')->store('payment_confirmations');
    //         $paymentConfirmation->proof_image = $proofImage;
    //         $paymentConfirmation->save();
    //     }

    //     return redirect()->route('payment_confirmations.index')->with('success', 'Payment confirmation updated successfully.');
    // }

    // public function destroy(PaymentConfirmation $paymentConfirmation)
    // {
    //     $paymentConfirmation->delete();
    //     return redirect()->route('payment_confirmations.index')->with('success', 'Payment confirmation deleted successfully.');
    // }

    // CLIENT
    public function indexClient()
    {
        $title = $this->title;
        $registrations = Registration::with('paymentConfirmation', 'event')->has('paymentConfirmation')->get();
        
        foreach ($registrations as $registration) {
            $registration->payment_status_name = $registration->payment_status == 0 ? 'Confirmation Process' : 'Paid';
        }

        return view('pages.payment_confirmations.client.index', compact('registrations', 'title'));
    }

    public function showClient(PaymentConfirmation $paymentConfirmation)
    {
        $title = $this->title;
        $registration = Registration::where('id', $paymentConfirmation->registration->id)->with('event')->first();
        $registration->payment_status_name = $registration->payment_status == 0 ? 'Confirmation Process' : 'Paid';
        return view('pages.payment_confirmations.client.show', compact('title', 'paymentConfirmation', 'registration'));
    }

    public function createClient()
    {
        $title = $this->title;
        $user = Auth::user();
        $registrations = Registration::with('event')->where('user_id', $user->id)->where('payment_status', 0)->get();
        return view('pages.payment_confirmations.client.create', compact('title', 'registrations'));
    }

    public function storeClient(Request $request)
    {
        $request->validate([
            'registration_id' => 'required',
            'payment_method' => 'required',
            'amount' => 'required',
            'payment_date' => 'required',
        ]);

        $paymentConfirmation = PaymentConfirmation::create($request->all());

        if ($request->hasFile('proof_image')) {
            $proofImage = $request->file('proof_image')->store('payment_confirmations', 'public');
            $paymentConfirmation->proof_image = $proofImage;
            $paymentConfirmation->save();
        }

        return redirect()->route('payment_confirmations.index')->with('success', 'Payment confirmation created successfully.');
    }
}
