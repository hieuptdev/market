<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Role_Permission;
use App\Validation\Validation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function __construct(Role $role, Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }

    public function index(Request $request)
    {
        if (!checkPermission('roles-read')) {
            return redirect()->route('admin.home')->with('noti', 'Not Permission')->with('status', 'danger');
        }
        $roles = $this->role->getListRole($request->all());
        return view('backend.role.index', compact('roles'));
    }

    public function create()
    {
        if (!checkPermission('roles-read') || !checkPermission('roles-create') || !checkPermission('roles-edit') || !checkPermission('roles-delete')) {
            return redirect()->route('admin.home')->with('noti', 'Not Permission')->with('status', 'danger');
        }
        $permissions = $this->permission->getAllPermission();
        return view('backend.role.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        Validation::createRole($request);
        // if ($this->role->saveDataRole($request->all())) {
        //     return redirect()->route('role.index')->with('noti', 'Create Success')->with('status', 'success');
        // }
        $role = new Role;
        $role->name = $request->name;
        $role->save();
        if ($request->permission_id != NULL) {
            foreach ($request->permission_id as $permission) {
                $role_per = new Role_Permission();
                $role_per->role_id = $role->id;
                $role_per->permission_id = $permission;
                $role_per->save();
            }
        }

        return redirect()->route('role.index')->with('noti', 'Create Success')->with('status', 'success');
    }

    public function edit($id)
    {
        if (!checkPermission('roles-read') || !checkPermission('roles-create') || !checkPermission('roles-edit') || !checkPermission('roles-delete')) {
            return redirect()->route('admin.home')->with('noti', 'Not Permission')->with('status', 'danger');
        }
        $permissions = $this->permission->getAllPermission();
        $role = $this->role->getRole($id);
        return view('backend.role.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {

        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();
        $role->permission()->sync($request->permission_id);
        // if ($this->role->saveDataRole($request->all(), $id)) {
        return redirect()->route('role.index')->with('noti', 'Edit Success')->with('status', 'success');
        // }
    }

    public function destroy($id)
    {

        if (!checkPermission('roles-read') || !checkPermission('roles-create') || !checkPermission('roles-edit') || !checkPermission('roles-delete')) {
            return redirect()->route('admin.home')->with('noti', 'Not Permission')->with('status', 'danger');
        };
        if ($this->role->deleteRole($id)) {
            return redirect()->route('role.index')->with('noti', 'Delete Success')->with('status', 'success');
        }
        return redirect()->route('role.index')->with('noti', 'Delete Faild')->with('status', 'danger');
    }
}
