<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id','prod_name','description','price'
    ];
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);//Определите обратное отношение «один к одному» или «многие».
    }

    public function order(): HasMany
    {
        return $this->hasMany(Order::class);//Определите отношение «один ко многим».
    }
}
