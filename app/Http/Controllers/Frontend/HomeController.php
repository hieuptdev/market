<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\Province;

class HomeController extends Controller
{
    public $user;
    public $product;
    public $category;
    public $province;
    public function __construct
    (
        User $user,
        Product $product, 
        Category $category,
        Province $province
    )
    {
        $this->user = $user;
        $this->product = $product;
        $this->category = $category;
        $this->province = $province;
    }
    public function index(Request $request)
    {
        $products = $this->product->getListProductActive($request->all());
        $rootCategory = $this->category->rootCategory();
        $categories = $this->category->allCategory();
        $provinces = $this->province->allProvince();
        return view('frontend.index', compact('products', 'rootCategory', 'categories', 'provinces'));
    }

    public function showProfile()
    {
        return view('frontend.user');
    }

    public function editProfile(Request $request)
    {
        $data['name'] = $request->name ? $request->name : null;
        $data['gender'] = $request->gender ? $request->gender : null;
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_avatar_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $data['avatar'] = $filename;
            $file->move('uploads/avatar/', $filename);
        } else {
            $data['avatar'] = null;
        }
        return response()->json($this->user->updateProfile($data));
    }

    public function productBycategory(Request $request, $id)
    {
        $category = $this->category->findCategory($id);
        $childCategory = $this->category->childCategory($id);
        $provinces = $this->province->allProvince();
        $products = $this->product->productByCategory($id, $request->all());
        return view('frontend.product.category', compact('category','products', 'childCategory', 'provinces'));
    }

    public function about()
    {
        return view('frontend.classyads.about');
    }


    public function contact()
    {
        return view('frontend.classyads.contact');
    }

    public function listings_single()
    {
        return view('frontend.classyads.listings-single');
    }


    public function listings()
    {
        return view('frontend.classyads.listings');
    }
}
