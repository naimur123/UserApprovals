<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    public function customers(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function items(){
        return $this->belongsTo(Items::class, 'item_id');
    }
    public function soltuion_types(){
        return $this->belongsTo(Solution::class, 'solution_id');
    }
    public function sales_types(){
        return $this->belongsTo(SalesTypes::class, 'sale_type_id');
    }
    public function payment_types(){
        return $this->belongsTo(PaymentTypes::class, 'payment_type_id');
    }
}
