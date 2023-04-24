<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateOrderNamesAndWeights implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $orders;

    /**
     * Create a new job instance.
     */
    public function __construct(array $orders)
    {
        $this->orders = $orders;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach($this->orders as $order){
            $order->recalculateTotalWeight();
            if(!$order->name){
                $order->update(['name' => $order->createAmusingName()]);
            }
        }
    }
}
