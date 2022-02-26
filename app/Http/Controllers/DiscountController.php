<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Exceptions\StockResponseException;

use App\Http\Resources\Discount\Resource;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;

class DiscountController extends Controller
{

    private function subTotal($items)
    {
        $result = 0;
        foreach ($items as $item)
        {
            $result += $item['total'];
        }
        return $result;
    }

    private function buy5Get1($items, $subTotalMaster=0): \stdClass
    {
        $amount = 0;
        $subtotal = 0;
        $subData = new \stdClass();
        foreach ($items as $item)
        {
            if ($item['quantity'] > 5)
            {
                $product = Product::where('id', $item->product_id)->first();
                if ($product->category_id == 2)
                {
                    $subData->reason = "BUY_5_GET_1";
                    $amount += floor($item['quantity'] / (5 + 1)) * $item['unit_price'];
                    $subData->amount = $amount;
                }
            }
            
        }
        
        if (!empty((array)$subData))
        {
            $subData->subtotal = $subTotalMaster - $subData->amount;
        }

        return $subData;
    }

    private function percent10ToOver1000($items, $subTotalMaster=0): \stdClass
    {
        $subData = new \stdClass();
        
        $total = 0;
        foreach ($items as $item)
        {
            $total += $item['total'];   
        }

        if ($total > 1000)
        {
            $subData->reason = "10_PERCENT_OVER_1000";
            $subData->amount = ($total * 10) / 100;
        }

        if (!empty((array)$subData))
        {
            $subData->subtotal = $subTotalMaster - $subData->amount;
        }

        return $subData;       
    }

    private function buyMore2Percent20($items, $subTotalMaster=0): \stdClass
    {
        $amount = 0;
        $subtotal = 0;
        $subData = new \stdClass();
        $data = [];
        $count = 0;
        $tempPrice = 0;
        foreach ($items as $item)
        {
            $product = Product::where('id', $item->product_id)->first();
            if ($product->category_id == 1)
            {
                $count += 1;
                if ($tempPrice < 1)
                    $tempPrice = $item['unit_price'];
                
                if (($count > 1 || $item['quantity'] > 1) && $tempPrice >= $item['unit_price'])
                {
                    $subData->reason = "BUY_MORE_2_PERCENT_20";
                    $amount = $item['unit_price'] * 20 / 100;
                    $subData->amount = $amount;
                    $tempPrice = $item['unit_price'];
                }
            }
        }

        if (!empty((array)$subData))
        {
            $subData->subtotal = $subTotalMaster - $subData->amount;
        }

        return $subData;
    }


    private function applyDiscount(Order $order)
    {
        $items = OrderItem::where('order_id', $order->id)->get();
        $subTotalMaster = $this->subTotal($items);
        $discountBuy5Get1 = $this->buy5Get1($items, $subTotalMaster);
        if (!empty((array)$discountBuy5Get1))
        {
            $subTotalMaster = $discountBuy5Get1->subtotal;
            $discounts[] = $discountBuy5Get1;
        }

        $discountPercent10ToOver1000 = $this->percent10ToOver1000($items, $subTotalMaster);
        if (!empty((array)$discountPercent10ToOver1000))
        {
            $subTotalMaster = $discountPercent10ToOver1000->subtotal;
            $discounts[] = $discountPercent10ToOver1000;
        }
            

        $discountBuyMore2Percent20 = $this->buyMore2Percent20($items, $subTotalMaster);
        if (!empty((array)$discountBuyMore2Percent20))
        {
            $subTotalMaster = $discountBuyMore2Percent20->subtotal;
            $discounts[] = $discountBuyMore2Percent20;
        }
            
        return $discounts;
    }

    public function show(Order $order): Resource
    {
        $discounts = $this->applyDiscount($order);

        $data = new \stdClass();
        $data->id = $order->id;
        $data->discounts[] = $this->applyDiscount($order);
        $totalDiscount = 0;
        foreach ($discounts as $discount)
        {
            $totalDiscount += $discount->amount;
        }
        $data->totalDiscount = $totalDiscount;
        $data->discountedTotal = collect($discounts)->last()->subtotal;


        return new Resource($data);
    }

}
