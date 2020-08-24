<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\FuncCall;

class Admin extends Model implements Authenticatable
{
    use AuthenticableTrait;
    protected $table = 'admin';

    protected $fillable = [
        'name', 'email', 'password', 'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id', 'id');
    }

    public function getListAdmin()
    {
        return $this->where('id', '!=', Auth::guard('admin')->user()->id)->paginate(numberPerPage());
    }
    public function getDataAdmin($id)
    {
        return $this->find($id);
    }

    public function saveDataAdmin($request, $id = null)
    {
        if (!isset($id)) {
            $admin = $this;
            $request['password'] = bcrypt($request['password']);
            return $admin->fill($request)->save();
        } else {
            $admin = $this->find($id);
            $request['password'] = bcrypt($request['password']);
            return $admin->fill($request)->save();
        }
    }

    public function deleteIdAdmin($id)
    {
        $admin = $this->find($id);
        return $admin->delete();
    }
}
