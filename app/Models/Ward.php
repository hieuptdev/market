<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $table = 'wards';

    public function allWard($id = null)
    {
    	if($id != null){
    		return $this->where('district_id', $id)->get();
    	}else{
    		return $this->all();
    	}
    }
}
