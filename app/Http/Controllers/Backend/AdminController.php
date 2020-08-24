<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Admin;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use App\Validation\Validation;
use Illuminate\Support\Facades\Redirect;
use Laravel\Ui\Presets\React;

class AdminController extends Controller
{
    public function __construct(Admin $admin, Role $role, Product $product, User $user)
    {
        $this->role = $role;
        $this->admin = $admin;
        $this->product = $product;
        $this->user = $user;
    }

    public function index()
    {
        $members = $this->user->totalUser();
        $products = $this->product->totalProduct();
        $customers = $this->product->totalCustomer();
        $sellers = $this->product->totalSeller();
        return view('backend.index', compact('members', 'products', 'sellers', 'customers'));
    }

    public function getLogin()
    {
        return view('backend.login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('admin.home');
        }
        return back()->with('error', 'Incorrect email or password.');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.get.login');
    }

    public function listAdmin()
    {
        if (!checkPermission('admin-read')) {
            return redirect()->route('admin.home')->with('noti', 'Not Permission')->with('status', 'danger');
        }
        $admin = $this->admin->getListAdmin();
        return view('backend.admin.index', compact('admin'));
    }

    public function createAdmin()
    {
        if (!checkPermission('admin-read') || !checkPermission('admin-create') || !checkPermission('admin-edit') || !checkPermission('admin-delete')) {
            return redirect()->route('admin.home')->with('noti', 'Not Permission')->with('status', 'danger');
        }
        $role = $this->role->getListRole();
        return view('backend.admin.create', compact('role'));
    }

    public function storeAdmin(Request $request)
    {
        Validation::adminValidate($request);
        $this->admin->saveDataAdmin($request->all());
        return redirect()->route('admin.list');
    }

    public function editAdmin($id)
    {
        if (!checkPermission('admin-read') || !checkPermission('admin-create') || !checkPermission('admin-edit') || !checkPermission('admin-delete')) {
            return redirect()->route('admin.home')->with('noti', 'Not Permission')->with('status', 'danger');
        }
        $admin = $this->admin->getDataAdmin($id);
        $role = $this->role->getListRole();
        return view('backend.admin.edit', compact('role', 'admin'));
    }

    public function updateAdmin(Request $request, $id)
    {
        $this->admin->saveDataAdmin($request->all(), $id);
        return redirect()->route('admin.list')->with('noti', 'Edit success')->with('status', 'success');
    }

    public function deleteAdmin($id)
    {
        if (!checkPermission('admin-read') || !checkPermission('admin-create') || !checkPermission('admin-edit') || !checkPermission('admin-delete')) {
            return redirect()->route('admin.home')->with('noti', 'Not Permission')->with('status', 'danger');
        }
        if ($this->admin->deleteIdAdmin($id)) {
            return redirect()->route('admin.list');
        }
    }
}
