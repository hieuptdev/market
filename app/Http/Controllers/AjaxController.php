<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
use App\Models\User;
use App\Models\Address;
use App\Models\Category;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeProduct;
use App\Models\Review;
use App\Mail\MailProduct;
use Mail;
class AjaxController extends Controller
{
	public $province;
	public $district;
	public $ward;
    public $address;
    public $category;
    public $product;
    public $attribute;
    public $attributeProduct;
    public $user;
    public $review;

    public function __construct(
        Province $province, 
        District $district, 
        Ward $ward,
        Address $address,
        Category $category,
        Product $product,
        Attribute $attribute,
        AttributeProduct $attributeProduct,
        User $user,
        Review $review
    )
    {
    	$this->province = $province;
    	$this->district = $district;
    	$this->ward = $ward;
        $this->address = $address;
        $this->category = $category;
        $this->product = $product;
        $this->attribute = $attribute;
        $this->attributeProduct = $attributeProduct;
        $this->user = $user;
        $this->review = $review;
    }

    public function getDistricts(Request $request)
    {
    	$districts = $this->district->allDistrict($request->province_id);
    	if($districts){
    		echo ' <option id="choose-district" value="">-- choose District --</option>';
    		foreach ($districts as $district) {
    			echo '<option value="'.$district->id.'"> '.$district->name.' </option>';
    		}
    	}else{
    		echo ' <option id="choose-district" value="">Province not available</option>';
    	}
    	
    }

    public function getWards(Request $request)
    {
        $wards = $this->ward->allWard($request->district_id);
        echo ' <option id="choose-district" value="">-- choose Ward --</option>';
        if($wards){
			foreach ($wards as $ward) {
				echo '<option value="'.$ward->id.'"> '.$ward->name.' </option>';
			}
        }else{
        	echo ' <option id="choose-district" value="">District not available</option>';
        }
    }


    public function getUserAddress(Request $request)
    {
        $userAddress = $this->address->getUserAddress($request->id);
        if($userAddress){
            echo '<div>
                <label for="cc-payment" class="control-label mb-1">Choose Address</label>
                </div>';
            foreach ($userAddress as $address) {
                echo '
                    <div class="row form-group">
                        <div class="col-1">
                            <br>
                                <input type="radio" id="seller_address" name="seller_address" value="'.$address->id.'" >
                            </div>
                            <div class="col-11">
                            <div class="card">
                                <div class="card-body">
                                     '.$address->street.', '.$address->ward->name.', '.$address->district->name.', '.$address->province->name.' 
                                </div>
                            </div>
                        </div>       
                    </div>';
            }
        }
    }

    public function getAttribute(Request $request)
    {
        $attributes = $this->attribute->categoryAttribute($request->id);
        $attributeProduct = $this->attributeProduct->getAttributeProduct($request->productId);
        if(isset($attributes) && isset($attributeProduct)){
            return response()->json(['attributes'=>$attributes, 'productAttr'=>$attributeProduct]);
        }else if(isset($attributes)){
             return response()->json(['attributes'=>$attributes]);
        }else{
             return response()->json([]);
        }
    }

    public function approveProduct(Request $request)
    {
        if($this->product->changeStatus($request->id, Product::ACTIVE)){
            $product = $this->product->findProduct($request->id);
            $user = $this->user->findUser($product->seller_id);
            $notification = "Your product is confirmed. Here's summary of your product.";
            Mail::to($user->email)->send(new MailProduct($product, $user, $notification));
            return response()->json('success');
        }    
        return response()->json('failed');
    }

    public function createReview(Request $request)
    {
        if($this->review->saveDataReview($request->all())){
            $this->user->updateAvgRate($request->seller_id, $this->review->getAvgStar($request->seller_id));
            return response()->json('success');
        }
        return response()->json('fail');
    }
}
