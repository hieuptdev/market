<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    protected $table = 'role';
    public function permission()
    {
        return $this->belongsToMany('App\Models\Permission', 'role_permission', 'role_id', 'permission_id');
    }
    protected $fillable = [
        'name',
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'role_id', 'id');
    }

    public function getRole($id)
    {
        return $this->find($id);
    }

    public function getListRole($data = null)
    {
        $roles = $this->Query();
        $search = isset($data['search']) ? $data['search'] : '';
        $roles->Where('name', 'like', '%' . $search . '%')->orwhereHas('permission', function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
        if (isset($data['sort'])) {
            $sort = $data['sort'];
            if ($sort == 'idasc') {
                $roles->orderBy('id', 'ASC');
            }
            if ($sort == 'iddesc') {
                $roles->orderBy('id', 'DESC');
            }
            if ($sort == 'nameasc') {
                $roles->orderBy('name', 'ASC');
            }
            if ($sort == 'namedesc') {
                $roles->orderBy('name', 'DESC');
            }
            if ($sort == 'createasc') {
                $roles->orderBy('created_at', 'ASC');
            }
            if ($sort == 'createdesc') {
                $roles->orderBy('created_at', 'DESC');
            }
        }
        return $roles->paginate(numberPerPage());
    }
    public function saveDataRole($request, $id = null)
    {
        if (!isset($id)) {
            $role = $this;
            $role->fill($request)->save();
            if ($request['permission_id'] != NULL) {
                foreach ($request['permission_id'] as $item) {
                    $role->permission()->sync($request['permission_id']);
                    return true;
                }
            }
            return false;
        } else {
            $role = $this->find($id);
            $role->fill($request)->save();
            if (isset($request['permission_id']) != NULL) {
                foreach ($request['permission_id'] as $item) {
                    $role->permission()->sync($request['permission_id']);
                    return true;
                }
            }
            return false;
        }
    }

    public function deleteRole($id)
    {
        $role = $this->find($id);
        Admin::where('role_id', $id)->update(["role_id" => NULL]);
        if ($role->delete()) {
            return true;
        }
        return false;
    }
}
