<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = ['order_date', 'customer_id'];
    protected $dates = ['deleted_at'];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function orderDate(): Attribute
    {
        return Attribute::make(
            // Mutator: Convert input format to MySQL format before saving
            set: fn ($value) => Carbon::createFromFormat('d/m/Y H:i:s', $value)->format('Y-m-d H:i:s'),
            // Accessor: Convert database format to user format when retrieving
            get: fn ($value) => Carbon::parse($value)->format('d/m/Y H:i:s')
        );
    }


}
