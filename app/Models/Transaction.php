<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';

    protected $fillable = [
        'code', 'user_id',  'shipping_price', 'total_price', 'shipping_courier', 'transaction_status', 'custom_card', 'transaction_date',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function transaction_details(){
        return $this->hasOne(TransactionDetail::class);
    }
}
