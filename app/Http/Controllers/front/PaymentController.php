<?php

namespace App\Http\Controllers\front;

use App\Models\Order;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Payment;
class PaymentController extends Controller
{
    public function create(Order $order)
    {
        return view('front.payments.create', [
            'order' => $order,
        ]);
    }

    public function createStripePaymentIntent(Order $order)
    {
        $stripe = new StripeClient(config('services.stripe.secret_key'));
        $amount = $order->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => 200,
            'currency' => 'usd',
            'payment_method_types' => ['card'],
        ]);

        return [
            'clientSecret' => $paymentIntent->client_secret,
        ];
    }

    public function confirm(Request $request, Order $order)
    {
        $stripe = new \Stripe\StripeClient(
            config('services.stripe.secret_key')
        );

        $paymentIntent = $stripe->paymentIntents->retrieve(
            $request->query('payment_intent'),
            []
        );
        if ($paymentIntent->status == 'succeeded') {
            $payment = new Payment();
            $payment
                ->forceFill([
                    'order_id' => $order->id,
                    'amount' => $paymentIntent->amount,
                    'currency' => $paymentIntent->currency,
                    'method' => 'stripe',
                    'status' => 'completed',
                    'transaction_id' => $paymentIntent->id,
                    'transaction_data' => json_encode($paymentIntent),
                ])
                ->save();

            return redirect()->route('home', [
                'status' => 'payment_successdd',
            ]);
        }
        return redirect()->route('orders.payments.create', [
            'order' => $order->id,
            'status' => 'payment_successdd',
        ]);
    }
}