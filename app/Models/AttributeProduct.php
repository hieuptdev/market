<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeProduct extends Model
{
    protected $table = 'attribute_product';

    protected $fillable = [
    	'product_id', 'attribute_id', 'values'
    ];

    public function getAttributeProduct($productId)
    {
    	return $this->where('product_id', $productId)->get();
    }

    public function attribute()
    {
    	return $this->belongsTo('App\Models\Attribute', 'attribute_id', 'id');
    }

}
