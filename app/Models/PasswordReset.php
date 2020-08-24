<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = 'password_resets';

    const UPDATED_AT = null;

    protected $fillable = [
        'email', 'token',
    ];

    public function store($data)
    {
        $passwordReset =  new $this;
        if ($passwordReset->fill($data)->save()) {
            $status = true;
        } else {
            $status = false;
        }
        return $status;
    }

    public function checkToken($token)
    {
        $result = $this->where('token', $token)->get()->toArray();
        return $result;
    }
}
