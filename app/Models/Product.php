<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name', 'slug', 'weight', 'price', 'description', 'stock', 'photo', 'store_id'
    ];

    public function user(){
        return $this->hasOne( User::class, 'id', 'users_id');
    }

    public function store(){
        return $this->belongsTo(Store::class);
    }

    public function productcategory(){
        return $this->hasMany(ProductCategory::class);
    }

}

