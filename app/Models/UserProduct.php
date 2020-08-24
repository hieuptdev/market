<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProduct extends Model
{
    protected $table = 'user_product';

    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
}
