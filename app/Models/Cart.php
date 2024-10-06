<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'userid',
        'productid',
        "quantity"

    ];
    protected $with = ['product'];
    public function product()
    {
        return $this->belongsTo(Product::class, 'productid');
    }
}
