<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Order;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\OrderUpdateRequest;

class OrderController extends Controller
{
    public function edit(Request $request, Order $order): Response
    {
        return Inertia::render('Orders/Edit', [
            'order' => $order->load('customer'),
            'orderItems' => $order->orderItems()->with('product.productCategory')->get()
        ]);
    }

    public function update(OrderUpdateRequest $request, Order $order): RedirectResponse
    {
        $order->fill($request->validated());

        $order->save();

        return Redirect::route('order.edit', ['order' => $order]);
    }

}
