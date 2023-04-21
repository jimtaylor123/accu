<?php

namespace App\Models;

use App\Models\Customer;
use App\Services\OrderService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function __construct(
        public OrderService $service = new OrderService()
    ) {}

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderItems(): ?HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function createAmusingName()
    {
        return $this->service->createAmusingName($this);
    }

    public function recalculateTotalWeight(): float
    {
        $orderItems = $this->orderItems;
        $weight = 0;
        foreach($orderItems as $orderItem){
            $weight = $weight + $orderItem->weight * $orderItem->quantity;
        }

        $this->update(['weight' => $weight]);

        return $weight;
    }
}
