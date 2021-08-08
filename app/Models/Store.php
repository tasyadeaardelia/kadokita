<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $table = 'store';

    protected $fillable = [
        'name', 'url', 'description', 'profil', 'is_approved', 'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
