<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Category, Product, User};
use App\Validation\Validation;
use Illuminate\Support\Str;
use App\Mail\MailProduct;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public $product;
    public $category;
    public $user;
    public function __construct(Product $product, Category $category, User $user)
    {
        $this->product = $product;
        $this->category = $category;
        $this->user = $user;
    }

    public function index(Request $request)
    {
        $products = $this->product->getDataProduct($request->category_id);
        return view('frontend.product.index', compact('products'));
    }

    public function detail(Request $request, $id)
    {
        $product = $this->product->findProduct($id, $this->product::ACTIVE);
        $otherProduct = $this->product->getListSellerProductExcept($id, $request->seller_id, $this->product::ACTIVE);
        return view('frontend.product.detail', compact('product', 'otherProduct'));

        return redirect()->route('index');
    }

    public function create()
    {
        $categories = $this->category->rootCategory();
        return view('frontend.product.create', compact('categories'));
    }

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
        $data['status'] = Product::PENDING;
        $product = $this->product->saveData($data);
        if ($product) {
            $user = $this->user->findUser($product->seller_id);
            $notification = "Your product is created. Here's summary of your product.";
            Mail::to($user->email)->send(new MailProduct($product, $user, $notification));
            return redirect()->route('user.product');
        }
        return back()->with('erorr', 'Something went wrong, please try again');
    }

    public function edit($id)
    {
        $product = $this->product->findProduct($id);
        $categories = $this->category->rootCategory();
        return view('frontend.product.edit', compact('product', 'categories'));
    }

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
        $data['status'] = Product::PENDING;
        if ($this->product->saveData($data, $id)) {
            return redirect()->route('user.product')->with('success', 'Edit product successfully');
        }
        return back()->with('erorr', 'Something went wrong, please try again');
    }

    public function destroy($id)
    {
        if ($this->product->checkStatus($id, $this->product::DELETED)) {
            $product = $this->product->findProduct($id);
            if ($this->product->deleteProduct($id)) {
                $user = $this->user->findUser($product->seller_id);
                $notification = "Your product is destroyed. Here's summary of your product.";
                Mail::to($user->email)->send(new MailProduct($product, $user, $notification));
                return redirect()->route('user.product');
            }
            return redirect()->route('user.product')->with('error', 'Something went wrong, please try again');
        }
        return redirect()->route('index');
    }
}
