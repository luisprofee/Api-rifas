<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Raffle extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'price',
        'date_end',
        'state'
    ];

    public function sales(){
        return $this->hasMany('App\Models\Sale');
    }
}
