<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'boleta_one',
        'boleta_two',
        'code',
        'client_id',
        'raffle_id'
    ];



    public function client(){
        return $this->belongsTo('App\Models\Client');
    }

    public function raffle(){
        return $this->belongsTo('App\Models\Raffle');
    }

    public function payments(){
        return $this->hasMany('App\Models\Payment');
    }

}
