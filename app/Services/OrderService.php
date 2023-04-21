<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class OrderService
{
    protected array $hilariousSuffixes = [
        "inator",
        "buster",
        "zilla",
        "spaculator",
        "boom-boom",
        "slingluch",
        "breaker",
        "dangledong",
        "wigglewiggle",
        "powwowwow",
        "fafifier",
        "combobulishor",
        "doofa",
        "spilancockler",
        "jerryator",
    ];

    public function createAmusingName(Order $order): string
    {
        $productChart = [];
        foreach($order->orderItems as $orderItem){
            $existingScore = isset($productChart[$orderItem->product->name])? $productChart[$orderItem->product->name] : 0;
            $productChart[$orderItem->product->name] = $existingScore + $orderItem->quantity;
        }

        arsort($productChart);
        $productChart = array_keys($productChart);
        $mostPopularProductName = $productChart[0];

        $randomWordFromProductName = Str::singular(Arr::random(array_filter(explode(' ', $mostPopularProductName), function($word){
            return !is_numeric($word);
        })));

        $amusingName = $randomWordFromProductName . " " . Arr::random($this->hilariousSuffixes);
        $match = Order::where('name', $amusingName)->first();

        // I could use a while loop here, but I avoid while loops in general, so I'm using a for loop with what seems like a maximum number of tries
        for($i = 0; $i < 10; $i++){
            $amusingName = $randomWordFromProductName . Arr::random($this->hilariousSuffixes);
            $match = Order::where('name', $amusingName)->first();
        }

        if($match){
            // If the name still isn't unique enough I could thrown an exception here, but I think it's better to just use a really weird name
            // Just in case we still haven't found a really random name, lets use some random latin words instead of the suffixes
            $amusingName = $randomWordFromProductName . join(fake()->words(3));
        }
        return $amusingName;
    }
}
