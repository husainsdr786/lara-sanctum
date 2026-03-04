<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ApiException;

class OrderService
{
    public function create($user, array $items)
    {
        return DB::transaction(function () use ($user, $items) {

            $subtotal = 0;
            $products = [];

            foreach ($items as $item) {

                $product = Product::where('id', $item['product_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($product->stock < $item['quantity']) {
                    throw new ApiException(
                        "Insufficient stock for {$product->name}",
                        422
                    );
                }

                $subtotal += $product->price * $item['quantity'];
                $products[] = [$product, $item['quantity']];

                $product->decrement('stock', $item['quantity']);
            }

            $tax = round($subtotal * 0.18, 2);
            $total = $subtotal + $tax;

            $order = Order::create([
                'user_id' => $user->id,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total
            ]);

            foreach ($products as [$product, $qty]) {
                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'price' => $product->price
                ]);
            }

            return $order->load('items.product');
        });
    }
}