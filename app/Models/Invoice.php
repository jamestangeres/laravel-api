<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public function customer() {
        // return $this->belongsTo('App\Models\Customer');
        return $this->belongsTo(Customer::class);
    }
}
