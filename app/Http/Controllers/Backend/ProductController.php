<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{Product, User, Category, Province};
use App\Validation\Validation;
use App\Mail\MailProduct;
use Illuminate\Support\Facades\Mail;

class ProductController extends Controller
{
    public $product;
    public $user;
    public $category;
    public $province;

    public function __construct(
        Product $product,
        User $user,
        Category $category,
        Province $province
    ) {
        $this->user = $user;
        $this->product = $product;
        $this->category = $category;
        $this->province = $province;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!checkPermission('product-read')) {
            return redirect()->route('admin.home')->with('noti', 'Not Permission')->with('status', 'danger');
        }
        $products = $this->product->getListProduct($request->all());
        $provinces = $this->province->allProvince();
        $categories = $this->category->allCategory();
        return view('backend.product.index', compact('products', 'provinces', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!checkPermission('product-read') || !checkPermission('product-create') || !checkPermission('product-edit') || !checkPermission('product-delete')) {
            return redirect()->route('admin.home')->with('noti', 'Not Permission')->with('status', 'danger');
        }
        $users = $this->user->getAllUser();
        $categories = $this->category->rootCategory();
        return view('backend.product.create', compact('users', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validation::productValidation($request);
        $data = $request->all();
        $arrImg = [];
        for ($i = 0; $i < count($request->image); $i++) {
            $file = $request->image[$i];
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/product/', $filename);
            array_push($arrImg, $filename);
        }
        $data['image'] = json_encode($arrImg);
        $product = $this->product->saveData($data);
        if ($product) {
            $user = $this->user->findUser($product->seller_id);
            $notification = "Your product is created. Here's summary of your product.";
            Mail::to($user->email)->send(new MailProduct($product, $user, $notification));
            return redirect()->route('product.index')->with('success', 'Create product successfully');
        }
        return back()->with('erorr', 'Something went wrong, please try again');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirmProduct($id)
    {
        if ($this->product->changeStatus($id, Product::ACTIVE)) {
            $product = $this->product->findProduct($id);
            $user = $this->user->findUser($product->seller_id);
            $notification = "Your product is confirmed. Here's summary of your product.";
            Mail::to($user->email)->send(new MailProduct($product, $user, $notification));
            return redirect()->route('product.index')->with('success', 'Product is confirmed');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!checkPermission('product-read') || !checkPermission('product-create') || !checkPermission('product-edit') || !checkPermission('product-delete')) {
            return redirect()->route('admin.home')->with('noti', 'Not Permission')->with('status', 'danger');
        }
        $users = $this->user->getAllUser();
        $categories = $this->category->rootCategory();
        $product = $this->product->findProduct($id);
        return view('backend.product.edit', compact('product', 'users', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validation::productValidation($request, $id);
        $data = $request->all();
        if ($request->hasFile('image')) {
            $arrImg = [];
            for ($i = 0; $i < count($request->image); $i++) {
                $file = $request->image[$i];
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/product/', $filename);
                array_push($arrImg, $filename);
            }
            $data['image'] = json_encode($arrImg);
        } else {
            $data['image'] = $request->oldImg;
        }
        if ($this->product->saveData($data, $id)) {
            return redirect()->route('product.index')->with('success', 'Edit product successfully');
        }
        return back()->with('erorr', 'Something went wrong, please try again');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!checkPermission('product-read') || !checkPermission('product-create') || !checkPermission('product-edit') || !checkPermission('product-delete')) {
            return redirect()->route('admin.home')->with('noti', 'Not Permission')->with('status', 'danger');
        }
        if ($this->product->deleteProduct($id)) {
            $product = $this->product->findProduct($id);
            if ($this->product->deleteProduct($id)) {
                $user = $this->user->findUser($product->seller_id);
                $notification = "Your product is destroyed. Here's summary of your product.";
                Mail::to($user->email)->send(new MailProduct($product, $user, $notification));
                return redirect()->route('product.index')->with('success', 'Delete product successfully!');
            }
        }
        return redirect()->route('product.index')->with('error', 'Something went wrong, please try again!');
    }
}
