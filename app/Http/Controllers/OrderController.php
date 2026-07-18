<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class OrderController extends Controller
{
    /**
     * Place a new order from the public menu page and generate Stripe Checkout URL.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'items'          => 'required|array|min:1',
            'items.*.id'     => 'required|integer|exists:products,id',
            'items.*.name'   => 'required|string',
            'items.*.price'  => 'required|numeric|min:0',
            'items.*.qty'    => 'required|integer|min:1',
            'notes'          => 'nullable|string|max:1000',
        ]);

        // Compute total server-side
        $total = collect($data['items'])->sum(fn($item) => $item['price'] * $item['qty']);

        // Create the order
        $order = Order::create([
            'customer_name'  => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'items'          => $data['items'],
            'total'          => $total,
            'notes'          => $data['notes'] ?? null,
            'status'         => 'pending', // Order pending kitchen
            'payment_status' => 'pending', // Payment pending Stripe
            'payment_method' => 'stripe',
        ]);

        // Build Stripe Line Items
        $lineItems = [];
        foreach ($data['items'] as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item['name'],
                    ],
                    'unit_amount' => intval($item['price'] * 100), // Stripe expects cents
                ],
                'quantity' => $item['qty'],
            ];
        }

        // Initialize Stripe
        Stripe::setApiKey(config('services.stripe.secret'));

        // Create Checkout Session
        $checkout_session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'customer_email' => $data['customer_email'],
            'client_reference_id' => $order->id,
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel') . '?order_id=' . $order->id,
        ]);

        // Save session ID to order
        $order->update(['stripe_session_id' => $checkout_session->id]);

        return response()->json([
            'success'      => true,
            'checkout_url' => $checkout_session->url,
        ]);
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        if (!$sessionId) {
            return redirect('/menu')->with('error', 'Invalid payment session.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));
        
        try {
            $session = Session::retrieve($sessionId);
            $orderId = $session->client_reference_id;
            
            $order = Order::findOrFail($orderId);
            
            // Mark payment as successful
            $order->update([
                'payment_status' => 'paid',
            ]);

            return view('checkout.success', compact('order'));
        } catch (\Exception $e) {
            return redirect('/menu')->with('error', 'There was an issue verifying your payment.');
        }
    }

    public function cancel(Request $request)
    {
        $orderId = $request->get('order_id');
        if ($orderId) {
            $order = Order::find($orderId);
            if ($order && $order->payment_status === 'pending') {
                $order->update([
                    'payment_status' => 'failed',
                    'status' => 'cancelled' // Cancel the whole order since they didn't pay
                ]);
            }
        }
        
        return view('checkout.cancel');
    }
}

