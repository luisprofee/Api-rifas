<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'pay',
        'sale_id'
    ];

    public function sale(){
        return $this->belongsTo('App\Models\Sale');
    }
}
