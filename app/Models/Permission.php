<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permission';
    public function getLitPermission()
    {
        return $this->paginate(numberPerPage());
    }
    public function getAllPermission()
    {
        return $this->all();
    }
}
