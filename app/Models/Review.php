<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;

class Review extends Model
{
    protected $table = 'reviews';
    protected $fillable = [
        'seller_id', 'customer_id', 'product_id', 'star', 'content',
    ];
    public function seller()
    {
        return $this->belongsTo('App\Models\User', 'seller_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\User', 'customer_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function getReview($data, $id = null)
    {
        if (!isset($id)) {
            $reviews = $this->Query();
            $search = isset($data['search']) ? $data['search'] : '';
            $reviews->where(function ($query) use ($search) {
                $query
                    ->where('content', 'like', '%' . $search . '%')
                    ->orwhereHas('seller', function ($query) use ($search) {
                        $query->where('username', 'like', '%' . $search . '%');
                    })
                    ->orwhereHas('customer', function ($query) use ($search) {
                        $query->where('username', 'like', '%' . $search . '%');
                    });;
            });
            if (isset($data['sort'])) {
                $sort = $data['sort'];
                if ($sort == 'idasc') {
                    $reviews->orderBy('id', 'ASC');
                }
                if ($sort == 'iddesc') {
                    $reviews->orderBy('id', 'DESC');
                }
                if ($sort == 'starasc') {
                    $reviews->orderBy('star', 'ASC');
                }
                if ($sort == 'stardesc') {
                    $reviews->orderBy('star', 'DESC');
                }
                if ($sort == 'createasc') {
                    $reviews->orderBy('created_at', 'ASC');
                }
                if ($sort == 'createdesc') {
                    $reviews->orderBy('created_at', 'DESC');
                }
            }
            return $reviews->paginate(numberPerPage());
        } else {
            return  $this->find($id);
        }
    }

    public function saveDataReview($data, $id = null)
    {
        if (!isset($id)) {
            $review = $this;
        } else {
            $review = $this->find($id);
        }
        return $review->fill($data)->save();
    }

    public function delReview($id)
    {
        $review = $this->find($id);
        if ($review) {

            return $review->delete();
        } else {
            return false;
        }
    }

    public function getAvgStar($seller_id)
    {
        return $this->where('seller_id', $seller_id)->avg('star');
    }
}
