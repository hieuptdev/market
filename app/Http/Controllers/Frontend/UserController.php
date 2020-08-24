<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{User, Address, Province, District, Ward, Product, Category};
use Illuminate\Support\Facades\Auth;
use App\Mail\MailPurchase;
use App\Validation\Validation;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public $user;
    public $address;
    public $province;
    public $district;
    public $ward;
    public $category;
    public function __construct(
        User $user,
        Address $address,
        Province $province,
        District $district,
        Ward $ward,
        Product $product,
        Category $category
    ) {
        $this->user = $user;
        $this->address = $address;
        $this->province = $province;
        $this->district = $district;
        $this->ward = $ward;
        $this->product = $product;
        $this->category = $category;
    }

    public function showProfile()
    {
        return view('frontend.user.account.profile');
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

    public function verifyPassword(Request $request)
    {
        $result = $request->validate([
            'password' => 'required|string|min:8',
        ]);
        $data = $request->all();
        $result = $this->user->verifyAccount($data);
        if ($result == true) {
            return response()->json('success');
        } else {
            return response()->json([
                'fail' => 'true',
                'errors'  => ['password' => 'Your password is in valid'],
            ], 400);
        }
    }

    public function getChangePassword()
    {
        return view('frontend.user.account.password');
    }

    public function postChangePassword(Request $request)
    {
        $request->validate([
            'currentPassword' => 'required|string|min:8',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $data['currentPassword'] = $request->currentPassword;
        $data['password'] = bcrypt($request->password);
        $result = $this->user->changePassword($data);
        if ($result == true) {
            $this->user->logout();
            return response()->json('success');
        } else {
            return response()->json([
                'fail' => 'true',
                'errors'  => ['currentPassword' => 'Current password is invalid'],
            ], 400);
        }
    }

    public function getAddress()
    {
        $provinces = $this->province->allProvince();
        $districts = $this->district->allDistrict();
        $wards = $this->ward->allWard();
        $userAddress = $this->address->getUserAddress(Auth::user()->id);
        return view('frontend.user.account.address', compact('userAddress', 'provinces', 'districts', 'wards'));
    }

    public function addAddress(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $result = $this->address->create($data);
        return response()->json($result);
    }

    public function changeDefaultAddress(Request $request)
    {
        $result = $this->address->changeDefault($request->id);
        return response()->json($result);
    }

    public function deleteAddress(Request $request)
    {
        $result = $this->address->deleteAddress($request->id);
        return response()->json($result);
    }

    public function editAddress(Request $request)
    {
        $provinces = $this->province->allProvince();
        $result = $this->address->findAddress($request->id);
        return response()->json(['editAddress' => $result, 'provinces' => $provinces]);
    }

    public function getListProduct(Request $request)
    {
        $products = $this->product->listProductBySeller(Auth::user()->id, $request->all());
        $categories = $this->category->allCategory();
        return view('frontend.user.product.index', compact('products', 'categories'));
    }

    public function getListPurchase(Request $request)
    {
        $products = $this->product->listProductByCustomer(Auth::user()->id, $request->all());
        $categories = $this->category->allCategory();
        return view('frontend.user.purchase.index', compact('products', 'categories'));
    }

    public function getListProductPendingApproval(Request $request)
    {
        $products = $this->product->listProductBySeller(Auth::user()->id, $request->all(), $this->product::PENDING_APPROVAL);
        $categories = $this->category->allCategory();
        return view('frontend.user.product.pending', compact('products','categories'));
    }

    public function getBuyNow($id)
    {
        if ($this->product->checkStatus($id, $this->product::ACTIVE)) {
            $product = $this->product->findProduct($id);
            $userAddress = $this->address->getUserAddress(Auth::user()->id);
            return view('frontend.user.product.buy_now', compact('product', 'userAddress'));
        }
        return redirect()->route('index');
    }

    public function postBuyNow(Request $request, $id)
    {
        Validation::buyNowValidation($request);
        if ($this->product->checkStatus($id, $this->product::ACTIVE)) {
            if ($this->product->updateProductInfo($id, Auth::user()->id, $request->customer_address, $this->product::PENDING_APPROVAL)) {
                return redirect()->route('user.purchase');
            }
            return redirect()->route('user.purchase')->with('error', 'Something went wrong, please try again');
        }
        return redirect()->route('index');
    }

    public function confirmProductPendingApproval($id)
    {
        if ($this->product->checkStatus($id, $this->product::PENDING_APPROVAL)) {
            if ($this->product->changeStatus($id, $this->product::SHIPPING)) {
                $product = $this->product->findProduct($id);
                $user = $this->user->findUser($product->customer_id);
                $notification = "Purchase order is confirmed. Thank you for your purchase. Here's summary of your purchase";
                $user['address'] = $this->address->getFullAddress($product->customer_address);
                Mail::to($user->email)->send(new MailPurchase($product, $user, $notification));
                return redirect()->route('user.product');
            }
            return redirect()->route('user.product.pending.approval')->with('error', 'Something went wrong, please try again');
        }
        return redirect()->route('index');
    }

    public function cancelProductPendingApproval($id)
    {
        if ($this->product->checkStatus($id, $this->product::PENDING_APPROVAL) || $this->product->checkStatus($id, $this->product::SHIPPING)) {
            $product = $this->product->findProduct($id);
            if ($this->product->updateProductInfo($id, null, null, $this->product::CANCELED)) {
                $user = $this->user->findUser($product->customer_id);
                $user['address'] = $this->address->getFullAddress($product->customer_address);
                $notification = "Your purchase order is canceled. Here's summary of your purchase";
                Mail::to($user->email)->send(new MailPurchase($product, $user, $notification));
                return redirect()->route('user.product');
            }
            return redirect()->route('user.purchase')->with('error', 'Something went wrong, please try again');
        }
        return redirect()->route('index');
    }

    public function cancelPurchase($id)
    {
        if ($this->product->checkStatus($id, $this->product::PENDING_APPROVAL)) {
            $product = $this->product->findProduct($id);
            if ($this->product->updateProductInfo($id, null, null, $this->product::CANCELED)) {
                $user = $this->user->findUser($product->customer_id);
                $user['address'] = $this->address->getFullAddress($product->customer_address);
                $notification = "Your purchase order is canceled. Here's summary of your purchase";
                Mail::to($user->email)->send(new MailPurchase($product, $user, $notification));
                return redirect()->route('user.purchase');
            }
            return redirect()->route('user.purchase')->with('error', 'Something went wrong, please try again');
        }
        return redirect()->route('index');
    }


    public function deleteProduct($id)
    {
        if ($this->product->checkStatus($id, $this->product::PENDING) || $this->product->checkStatus($id, $this->product::ACTIVE) || $this->product->checkStatus($id, $this->product::CANCELED) || $this->product->checkStatus($id, $this->product::PENDING_APPROVAL)) {
            if ($this->product->changeStatus($id, $this->product::DELETED)) {
                return redirect()->route('user.product')->with('success', 'Product is deleted');
            }
            return redirect()->route('user.product')->with('error', 'Something went wrong, please try again');
        }
        return redirect()->route('index');
    }

    public function completePurchase($id)
    {
        if ($this->product->changeStatus($id, $this->product::SHIPPING)) {
            $product = $this->product->findProduct($id);
            if ($this->product->changeStatus($id, $this->product::DELIVERED)) {
                $user = $this->user->findUser($product->customer_id);
                $user['address'] = $this->address->getFullAddress($product->customer_address);
                $notification = "Your purchase is delivered. Here's summary of your purchase";
                Mail::to($user->email)->send(new MailPurchase($product, $user, $notification));
                return redirect()->route('user.product');
            }
            return redirect()->route('user.product')->with('error', 'Something went wrong, please try again');
        }
        return redirect()->route('index');
    }
}
