<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\InvoiceProduct;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['total', 'discount', 'vat', 'payable', 'user_id', 'customer_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // public function invoice_product()
    // {
    //     return $this->hasMany(InvoiceProduct::class);
    // }
}
