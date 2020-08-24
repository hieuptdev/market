<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Address extends Model
{
    protected $table = 'address';

    protected $fillable = [
        'user_id', 'province_id', 'district_id', 'ward_id', 'street', 'default',
    ];

    public function province()
    {
        return $this->hasOne('App\Models\Province', 'id', 'province_id');
    }

    public function district()
    {
        return $this->hasOne('App\Models\District', 'id', 'district_id');
    }

    public function ward()
    {
        return $this->hasOne('App\Models\Ward', 'id', 'ward_id');
    }

    public function create($data)
    {
        if (isset($data['address_id'])) {
            return $this->where('id', $data['address_id'])
                ->update([
                    'province_id' => $data['province_id'],
                    'district_id' => $data['district_id'],
                    'ward_id' => $data['ward_id'],
                    'street' => $data['street'],
                ]);
        } else {
            return $this->fill($data)->save();
        }
    }

    public function getUserAddress($id)
    {
        return $this->where('user_id', $id)->get();
    }

    public function findAddress($id)
    {
        return $this->find($id);
    }

    public function getFullAddress($id)
    {
        $address = $this->find($id);
        return $address->street.', '.$address->ward->name.', '.$address->district->name.', '.$address->province->name;
    }

    public function changeDefault($id)
    {
        if ($this->where('user_id', Auth::user()->id)->update(['default' => 0])) {
            return $this->where('id', $id)->update(['default' => 1]);
        }
        return false;
    }

    public function deleteAddress($id)
    {
        $address = $this->where('id', $id)->get()->toArray();
        if ($address[0]['default'] == 1) {
            return false;
        } else {
            return $this->find($id)->delete();
        }
    }
}
