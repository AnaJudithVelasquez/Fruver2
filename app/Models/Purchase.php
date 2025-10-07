<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['product_id', 'cantidad', 'precio_compra', 'fecha', 'proveedor'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
