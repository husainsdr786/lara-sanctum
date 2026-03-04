<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function store(
        StoreOrderRequest $request,
        OrderService $service
    ) {
        $order = $service->create(
            auth()->user(),
            $request->validated()['items']
        );

        return response()->json([
            'message' => 'Order created successfully',
            'data' => new OrderResource($order)
        ], 201);
    }
}