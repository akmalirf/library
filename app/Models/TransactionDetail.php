<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_id','member_id','date_start','date_end','status','book_id'];

    
    public function Transaction()
    {
        
        return $this->belongsTo('App\Models\Transaction', 'transaction_id');
    }

    public function Books()
    {
        return $this->hasMany('App\Models\Book', 'id', 'book_id');
    }
}

