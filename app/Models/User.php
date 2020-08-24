<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\{Wards, Province, District, Address};

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'email', 'password', 'phone', 'status', 'avatar', 'gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function address()
    {
        return $this->hasMany('App\Models\Address');
    }

    public function product()
    {
        return $this->hasMany('App\Models\Product', 'seller_id', 'id');
    }

    public function review()
    {
        return $this->hasMany('App\Models\Review', 'seller_id', 'id');
    }

    public function getUserAddressDefault()
    {
        return $this->address()->where('default', 1);
    }

    public function updateAvgRate($id, $avg_rate)
    {
        return $this->where('id', $id)->update(['avg_rate' => $avg_rate]);
    }

    public function verifyAccount($data)
    {
        $user = $this->where('id', Auth::user()->id)->get()->toArray();
        if ($user) {
            if (Hash::check($data['password'], $user[0]['password'])) {
                $status = true;
            } else {
                $status = false;
            }
        } else {
            $status = false;
        }
        return $status;
    }

    public function getListUser($data)
    {
        $users = $this->Query();
        $search = isset($data['search']) ? $data['search'] : '';
        $users->where(function ($query) use ($search) {
            $query
                ->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('username', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%');
        });
        if (isset($data['province'])) {
            $province = $data['province'];
            $users->whereHas('address', function ($query) use ($province) {
                $query->where('province_id', $province);
            });
        }
        if (isset($data['district'])) {
            $district = $data['district'];
            $users->whereHas('address', function ($query) use ($district) {
                $query->where('district_id', $district);
            });
        }
        if (isset($data['ward'])) {
            $ward = $data['ward'];
            $users->whereHas('address', function ($query) use ($ward) {
                $query->where('ward_id', $ward);
            });
        }
        if (isset($data['status'])) {
            $users->where('status', $data['status']);
        }
        if (isset($data['gender'])) {
            $users->where('gender', $data['gender']);
        }
        if (isset($data['rate'])) {
            $users->where('avg_rate', '>=', $data['rate']);
        }
        if (isset($data['sort'])) {
            $sort = $data['sort'];
            if ($sort == 'idasc') {
                $users->orderBy('id', 'ASC');
            }
            if ($sort == 'iddesc') {
                $users->orderBy('id', 'DESC');
            }
            if ($sort == 'nameasc') {
                $users->orderBy('name', 'ASC');
            }
            if ($sort == 'namedesc') {
                $users->orderBy('name', 'DESC');
            }
            if ($sort == 'emailasc') {
                $users->orderBy('email', 'ASC');
            }
            if ($sort == 'emaildesc') {
                $users->orderBy('email', 'DESC');
            }
            if ($sort == 'phoneasc') {
                $users->orderBy('phone', 'ASC');
            }
            if ($sort == 'phonedesc') {
                $users->orderBy('phone', 'DESC');
            }
            if ($sort == 'statusasc') {
                $users->orderBy('status', 'ASC');
            }
            if ($sort == 'statusdesc') {
                $users->orderBy('status', 'DESC');
            }
            if ($sort == 'rateasc') {
                $users->orderBy('avg_rate', 'ASC');
            }
            if ($sort == 'ratedesc') {
                $users->orderBy('avg_rate', 'DESC');
            }
            if ($sort == 'totalboughtdesc') {
                $users->orderBy('avg_rate', 'DESC');
            }
            if ($sort == 'totalboughtasc') {
                $users->orderBy('avg_rate', 'ASC');
            }
            if ($sort == 'createasc') {
                $users->orderBy('created_at', 'ASC');
            }
            if ($sort == 'createdesc') {
                $users->orderBy('created_at', 'DESC');
            }
        }
        return $users->paginate(numberPerPage());
    }

    public function getAllUser($user_id = null)
    {
        if (!$user_id) {
            return $this->all();
        } else {
            return $this->where('id', '!=', $user_id)->get();
        }
    }

    public function getAddress()
    {
        return Province::all();
    }
    // public function role()
    // {
    //     return $this->hasOne('App\Models\Role', 'role_id', 'id');
    // }

    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id', 'id');
    }

    public function findUser($id)
    {
        return $this->find($id);
    }

    public function saveDataUser($data, $id = null)
    {
        if (!isset($id)) {
            $user = $this;
            $data['password'] = bcrypt($data['password']);
            if ($user->fill($data)->save()) {
                return $user->id;
            }
            return false;
        } else {
            $user = $this->find($id);
            $user->name = $data['name'];
            $user->username = $data['username'];
            $user->email = $data['email'];
            $user->gender = $data['gender'];
            $user->phone = $data['phone'];
            $user->status = $data['status'];
            if (isset($data['changepass'])) {
                $user->password = bcrypt($data['password']);
            }
            return $user->save();
        }
    }

    public function updateProfile($data)
    {
        $user = $this->find(Auth::user()->id);
        $user->name = $data['name'];
        $user->gender = $data['gender'];
        if ($data['avatar'] != null) {
            $user->avatar = $data['avatar'];
        }
        return $user->save();
    }

    public function createUser($data)
    {
        $user = $this;
        if ($user->fill($data)->save()) {
            $status = true;
        } else {
            $status = false;
        }
        return $status;
    }

    public function deleteUser($id)
    {
        $user = $this->find($id);
        return $user->delete();
    }

    public function changePassword($data)
    {
        if (Hash::check($data['currentPassword'], Auth::user()->password)) {
            if ($this->where('email', Auth::user()->email)->update(['password' => $data['password']])) {
                $status = true;
            } else {
                $status = false;
            }
        } else {
            $status = false;
        }
        return $status;
    }

    public function changeEmail($data)
    {
        $user = $this->where('email', $data['newEmail']);
        if ($user->count() > 0) {
            $status = false;
        } else {
            if ($this->where('email', $data['email'])->update(['email' => $data['newEmail']])) {
                $status = true;
            } else {
                $status = false;
            }
        }
        return $status;
    }

    public function changePhone($data)
    {
        $user = $this->where('phone', $data['newPhone']);
        if ($user->count() > 0) {
            $status = false;
        } else {
            if ($this->where('phone', $data['phone'])->update(['phone' => $data['newPhone']])) {
                $status = true;
            } else {
                $status = false;
            }
        }
        return $status;
    }

    public function totalUser()
    {
        return $this->all()->count();
    }
}
