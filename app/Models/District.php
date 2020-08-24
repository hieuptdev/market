<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';

    public function allDistrict($id = null)
    {
    	if($id != null){
    		return $this->where('province_id', $id)->get();
    	}else{
    		return $this->all();
    	}
    }
}
