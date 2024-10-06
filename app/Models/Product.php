<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'price',
        'description',
        'quantity',
        'category',
        'rating',
        'thumbnail',
        'images'

    ];
    protected $with = ['cat'];
    public function cat()
    {
        return $this->belongsTo(Category::class, "category");
    }
}
