<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Role, User, Province, Address, Product};
use App\Validation\Validation;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public $user;
    public $province;
    public $address;
    public $role;
    public $product;

    public function __construct(
        User $user,
        Province $province,
        Address $address,
        Role $role,
        Product $product
    ) {
        $this->user = $user;
        $this->province = $province;
        $this->address = $address;
        $this->role = $role;
        $this->product = $product;
    }

    public function index(Request $request)
    {
        if (!checkPermission('user-read')) {
            return redirect()->route('admin.home')->with('noti', 'Not Permission')->with('status', 'danger');
        }
        $provinces = $this->province->allProvince();
        $users = $this->user->getListUser($request->all());
        return view('backend.user.index', compact('users', 'provinces'));
    }

    public function address($id)
    {
        $provinces = $this->province->allProvince();
        $userAddress = $this->address->getUserAddress($id);
        return view('backend.user.address', compact('userAddress', 'provinces'));
    }

    public function create()
    {
        if (!checkPermission('user-read') || !checkPermission('user-create')) {
            return redirect()->route('admin.home')->with('noti', 'Not Permission')->with('status', 'danger');
        }
        $roles = $this->role->getListRole();
        $provinces = $this->province->allProvince();
        return view('backend.user.create', compact('provinces', 'roles'));
    }

    public function edit($id)
    {
        if (!checkPermission('user-read') || !checkPermission('user-create') || !checkPermission('user-edit')) {
            return redirect()->route('admin.home')->with('noti', 'Not Permission')->with('status', 'danger');
        }
        $roles = $this->role->getListRole();
        $user = User::find($id);
        $provinces = $this->province->allProvince();
        $totalBought = $this->product->totalBought($id, $this->product::DELIVERED);
        $totalSold = $this->product->totalSold($id, $this->product::DELIVERED);
        return view('backend.user.edit', compact('user', 'provinces', 'totalBought', 'totalSold'));
    }

    public function store(Request $request)
    {
        Validation::userStore($request);
        $data = $request->all();
        DB::beginTransaction();
        try {
            $result = $this->user->saveDataUser($data);
            $credentials = [];
            $credentials['province_id'] = $data['province_id'];
            $credentials['district_id'] = $data['district_id'];
            $credentials['ward_id'] = $data['ward_id'];
            $credentials['street'] = $data['street'];
            $credentials['user_id'] = $result;
            $credentials['default'] = 1;
            $this->address->create($credentials);
            DB::commit();
            return redirect()->route('user.index')->with('success', 'Add user successfully!');
        } catch (Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong, please try again');
        }
    }




    public function update(Request $request, $id)
    {
        Validation::userUpdate($request, $id);
        if ($this->user->saveDataUser($request->all(), $id)) {
            return redirect()->route('user.index')->with('success', 'Update user infomation successfully!');
        }
        return back()->with('error', 'Something went wrong, please try again');
    }

    public function delete($id)
    {
        if (!checkPermission('user-read') || !checkPermission('user-create') || !checkPermission('user-edit') || !checkPermission('user-delete')) {
            return redirect()->route('admin.home')->with('noti', 'Not Permission')->with('status', 'danger');
        }
        if ($this->user->deleteUser($id)) {
            return redirect()->route('user.index')->with('success', 'Delete user successfully!');
        }
        return redirect()->route('user.index')->with('error', 'Something went wrong, please try again');
    }
}
