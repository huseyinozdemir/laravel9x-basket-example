<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\Order\Collection;
use App\Http\Resources\Order\Resource;
use App\Http\Requests\Order\StoreRequest;
use App\Http\Requests\Order\UpdateRequest;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;


class OrderController extends Controller
{

    public function index(): Collection
    {
        $orders = Order::all();
        return new Collection($orders);
    }

    private function itemsCreateOrUpdate($items, $orderId) {
        $order = OrderItem::where('order_id', $orderId)->delete();
        $total = 0;
        foreach ($items as $item) {
            if (!isset($item['unit_price'])) {
                $product = Product::findOrFail($item['product_id']);
                $item['unit_price'] = $product->price;
            }

            $data = [];
            $data['order_id'] = $orderId;
            $data['product_id'] = $item['product_id'];
            $data['quantity'] = $item['quantity'];
            $data['unit_price'] = $item['unit_price'];
            $data['total'] = $item['quantity'] * $item['unit_price'];
            OrderItem::create($data);
            $total += $data['total'];
        }
        return $total;
    }

    public function store(StoreRequest $request): Resource
    {
        $data = $request->validated();
        $orderData = [];
        $orderData['customer_id'] = $data['customer_id'];
        $order = Order::create($orderData);
        $orderData['total'] = $this->itemsCreateOrUpdate($data['items'], $order->id);
        $order->update($orderData);
        return new Resource($order);
    }

    public function update(UpdateRequest $request, Order $order): Resource
    {
        $data = $request->validated();
        $orderData = [];
        $orderData['customer_id'] = $data['customer_id'];
        $orderData['total'] = $this->itemsCreateOrUpdate($data['items'], $order->id);
        $order->update($orderData);
        return new Resource($order);
    }

    public function show(Order $order): Resource
    {
        return new Resource($order);
    }

    public function delete(Order $order): Resource
    {
        $order->delete();
        return new Resource($order);
    }
}
