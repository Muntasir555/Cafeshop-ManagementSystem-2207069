<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Place a new order from the public menu page.
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

        // Compute total server-side (don't trust client total)
        $total = collect($data['items'])->sum(fn($item) => $item['price'] * $item['qty']);

        $order = Order::create([
            'customer_name'  => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'items'          => $data['items'],
            'total'          => $total,
            'notes'          => $data['notes'] ?? null,
            'status'         => 'pending',
        ]);

        return response()->json([
            'success'  => true,
            'order_id' => $order->id,
            'message'  => 'Your order has been placed! Order #' . $order->id,
        ]);
    }
}
