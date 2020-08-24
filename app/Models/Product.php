<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    const PENDING = 1;
    const ACTIVE = 2;
    const PENDING_APPROVAL = 3;
    const SHIPPING = 4;
    const DELIVERED = 5;
    const CANCELED = 6;
    const DELETED = 7;

    protected $table = 'products';

    protected $fillable = [
        'seller_id', 'customer_id', 'title', 'category_id', 'price', 'desc', 'image', 'status', 'seller_address', 'customer_address'
    ];

    public function address()
    {
        return $this->belongsTo('App\Models\Address', 'seller_address', 'id');
    }

    public function review()
    {
        return $this->belongsTo('App\Models\Review', 'id', 'product_id');
    }

    public function attribute()
    {
        return $this->belongsToMany('App\Models\Attribute', 'attribute_product', 'product_id', 'attribute_id')->withTimeStamps();;
    }

    public function attributeProduct()
    {
        return $this->hasMany('App\Models\AttributeProduct', 'product_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    public function getListProductActive($data)
    {
        $products = $this->Query();
        $search = isset($data['search']) ? $data['search'] : '';
        $products->where('status', $this::ACTIVE);
        $products->where(function ($query) use ($search) {
            $query
                ->where('title', 'like', '%' . $search . '%')
                ->orWhere('desc', 'like', '%' . $search . '%')
                ->orwhereHas('seller', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')->orWhere('username', 'like', '%' . $search . '%');
                })
                ->orwhereHas('customer', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')->orWhere('username', 'like', '%' . $search . '%');
                });
        });
        if (isset($data['province'])) {
            $province = $data['province'];
            $products->whereHas('address', function ($query) use ($province) {
                $query->where('province_id', $province);
            });
        }
        if (isset($data['category'])) {
            $products->where('category_id', $data['category']);
        }
        if (isset($data['sort'])) {
            $sort = $data['sort'];
            if ($sort == 'titleasc') {
                $products->orderBy('title', 'ASC');
            }
            if ($sort == 'titledesc') {
                $products->orderBy('title', 'DESC');
            }
            if ($sort == 'priceasc') {
                $products->orderBy('price', 'ASC');
            }
            if ($sort == 'pricedesc') {
                $products->orderBy('price', 'DESC');
            }
            if ($sort == 'avgrateasc') {
                $products->whereHas('seller', function ($query) {
                    $query->orderBy('avg_rate', 'ASC');
                });
            }
            if ($sort == 'avgratedesc') {
                $products->whereHas('seller', function ($query) {
                    $query->orderBy('avg_rate', 'DESC');
                });
            }
            if ($sort == 'latest') {
                $products->orderBy('created_at', 'DESC');
            }
        }
        return $products->paginate(numberPerPage());
    }

    public function changeStatus($id, $status)
    {
        return $this->where('id', $id)->update(['status' => $status]);
    }

    public function seller()
    {
        return $this->belongsTo('App\Models\User', 'seller_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\User', 'customer_id', 'id');
    }

    public function getListProduct($data)
    {
        $products = $this->Query();
        $search = isset($data['search']) ? $data['search'] : '';
        $products->where(function ($query) use ($search) {
            $query
                ->where('title', 'like', '%' . $search . '%')
                ->orWhere('desc', 'like', '%' . $search . '%')
                ->orwhereHas('seller', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')->orWhere('username', 'like', '%' . $search . '%');
                })
                ->orwhereHas('customer', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')->orWhere('username', 'like', '%' . $search . '%');
                });;
        });
        if (isset($data['province'])) {
            $province = $data['province'];
            $products->whereHas('address', function ($query) use ($province) {
                $query->where('province_id', $province);
            });
        }
        if (isset($data['district'])) {
            $district = $data['district'];
            $products->whereHas('address', function ($query) use ($district) {
                $query->where('district_id', $district);
            });
        }
        if (isset($data['ward'])) {
            $ward = $data['ward'];
            $products->whereHas('address', function ($query) use ($ward) {
                $query->where('ward_id', $ward);
            });
        }
        if (isset($data['category'])) {
            $products->where('category_id', $data['category']);
        }
        if (isset($data['status'])) {
            $products->where('status', $data['status']);
        }
        if (isset($data['sort'])) {
            $sort = $data['sort'];
            if ($sort == 'idasc') {
                $products->orderBy('id', 'ASC');
            }
            if ($sort == 'iddesc') {
                $products->orderBy('id', 'DESC');
            }
            if ($sort == 'titleasc') {
                $products->orderBy('title', 'ASC');
            }
            if ($sort == 'titledesc') {
                $products->orderBy('title', 'DESC');
            }
            if ($sort == 'priceasc') {
                $products->orderBy('price', 'ASC');
            }
            if ($sort == 'pricedesc') {
                $products->orderBy('price', 'DESC');
            }
            if ($sort == 'statusasc') {
                $products->orderBy('status', 'ASC');
            }
            if ($sort == 'statusdesc') {
                $products->orderBy('status', 'DESC');
            }
            if ($sort == 'createasc') {
                $products->orderBy('created_at', 'ASC');
            }
            if ($sort == 'createdesc') {
                $products->orderBy('created_at', 'DESC');
            }
        }
        return $products->paginate(numberPerPage());
    }

    public function listProductBySeller($seller_id, $data, $status = null)
    {
        $products = $this->Query();
        $search = isset($data['search']) ? $data['search'] : '';
        $products->where('seller_id', $seller_id)->where('title', 'like', '%' . $search . '%');
        if ($status != null) {
            $products->where('status', $status);
        }
        if (isset($data['category'])) {
            $products->where('category_id', $data['category']);
        }
        if (isset($data['status'])) {
            $products->where('status', $data['status']);
        }
        if (isset($data['sort'])) {
            $sort = $data['sort'];
            if ($sort == 'titleasc') {
                $products->orderBy('title', 'ASC');
            }
            if ($sort == 'titledesc') {
                $products->orderBy('title', 'DESC');
            }
            if ($sort == 'priceasc') {
                $products->orderBy('price', 'ASC');
            }
            if ($sort == 'pricedesc') {
                $products->orderBy('price', 'DESC');
            }
            if ($sort == 'createasc') {
                $products->orderBy('created_at', 'ASC');
            }
            if ($sort == 'createdesc') {
                $products->orderBy('created_at', 'DESC');
            }
        }
        return $products->paginate(numberPerPage() - 3);
    }

    public function getListProductHaveNoCustomer()
    {
        return $this->where('customer_id', null)->get();
    }

    public function listProductByCustomer($customer_id, $data)
    {
        $products = $this->Query();
        $search = isset($data['search']) ? $data['search'] : '';
        $products->where('customer_id', $customer_id)->where('title', 'like', '%' . $search . '%');
        if (isset($data['category'])) {
            $products->where('category_id', $data['category']);
        }
        if (isset($data['status'])) {
            $products->where('status', $data['status']);
        }
        if (isset($data['sort'])) {
            $sort = $data['sort'];
            if ($sort == 'titleasc') {
                $products->orderBy('title', 'ASC');
            }
            if ($sort == 'titledesc') {
                $products->orderBy('title', 'DESC');
            }
            if ($sort == 'priceasc') {
                $products->orderBy('price', 'ASC');
            }
            if ($sort == 'pricedesc') {
                $products->orderBy('price', 'DESC');
            }
            if ($sort == 'createasc') {
                $products->orderBy('created_at', 'ASC');
            }
            if ($sort == 'createdesc') {
                $products->orderBy('created_at', 'DESC');
            }
        }
        return $products->paginate(numberPerPage() - 3);
    }

    public function getListSellerProductExcept($id, $seller_id, $status)
    {
        return $this->where('id', '!=', $id)->where('seller_id', $seller_id)->where('status', $status)->get();
    }

    public function productByCategory($id, $data)
    {
        $products = $this->Query();
        $search = isset($data['search']) ? $data['search'] : '';
        $products->where('status', $this::ACTIVE);
        $products->whereHas('category', function ($query) use ($id) {
            $query->where('parent_id', $id);
        });
        $products->where(function ($query) use ($search) {
            $query
                ->where('title', 'like', '%' . $search . '%')
                ->orWhere('desc', 'like', '%' . $search . '%')
                ->orwhereHas('seller', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')->orWhere('username', 'like', '%' . $search . '%');
                })
                ->orwhereHas('customer', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')->orWhere('username', 'like', '%' . $search . '%');
                });
        });
        if (isset($data['province'])) {
            $province = $data['province'];
            $products->whereHas('address', function ($query) use ($province) {
                $query->where('province_id', $province);
            });
        }
        if (isset($data['category'])) {
            $products->where('category_id', $data['category']);
        }
        if (isset($data['sort'])) {
            $sort = $data['sort'];
            if ($sort == 'titleasc') {
                $products->orderBy('title', 'ASC');
            }
            if ($sort == 'titledesc') {
                $products->orderBy('title', 'DESC');
            }
            if ($sort == 'priceasc') {
                $products->orderBy('price', 'ASC');
            }
            if ($sort == 'pricedesc') {
                $products->orderBy('price', 'DESC');
            }
            if ($sort == 'avgrateasc') {
                $products->whereHas('seller', function ($query) {
                    $query->orderBy('avg_rate', 'ASC');
                });
            }
            if ($sort == 'avgratedesc') {
                $products->whereHas('seller', function ($query) {
                    $query->orderBy('avg_rate', 'DESC');
                });
            }
            if ($sort == 'latest') {
                $products->orderBy('created_at', 'DESC');
            }
        }
        return $products->paginate(numberPerPage());
    }

    public function updateProductInfo($product_id, $customer_id, $customer_address, $status)
    {
        return $this->where('id', $product_id)->update(['customer_id' => $customer_id, 'customer_address' => $customer_address, 'status' => $status]);
    }

    public function findProduct($id, $status = null)
    {
        if ($status != null) {
            return $this->where('id', $id)->where('status', $status)->get();
        }
        return $this->find($id);
    }

    public function totalBought($id, $status)
    {
        return $this->where('customer_id', $id)->where('status', $status)->get();
    }

    public function totalSold($id, $status)
    {
        return $this->where('seller_id', $id)->where('status', $status)->get();
    }

    public function checkStatus($id, $status)
    {
        return $this->where('id', $id)->where('status', $status)->get()->count();
    }

    public function deleteProduct($id)
    {
        $product = $this->find($id);
        return $product->delete();
    }

    public function saveData($data, $id = null)
    {
        if ($id != null) {
            $product = $this->find($id);
            if ($product->fill($data)->save()) {
                for ($i = 0; $i < count($data['attributes']['name']); $i++) {
                    $attribute[$data['attributes']['attributeId'][$i]] = ['values' => $data['attributes']['values'][$i]];
                }
                $product->attribute()->sync($attribute);
                return true;
            }
            return false;
        } else {
            $product = new $this;
            if ($product->fill($data)->save()) {
                for ($i = 0; $i < count($data['attributes']['name']); $i++) {
                    $attribute[$data['attributes']['attributeId'][$i]] = ['values' => $data['attributes']['values'][$i]];
                }
                $product->attribute()->sync($attribute);
                return $product;
            }
            return false;
        }
    }

    public function totalProduct()
    {
        return $this->all()->count();
    }

    public function totalCustomer()
    {
        return $this->distinct('customer_id')->count();
    }

    public function totalSeller()
    {
        return $this->distinct('seller_id')->count();
    }
}
