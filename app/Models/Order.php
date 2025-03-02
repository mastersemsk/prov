<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id','fio','status','final_price','comment'
    ];
    public function product(): BelongsTo
    {
        return $this->BelongsTo(Product::class);
    }
}
