<?php

namespace App\Validation;

class Validation
{


    public static function adminValidate($request)
    {
        return $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|unique:admin',
            'password' => 'required|min:8',
            'confirm_password' => 'bail|required|same:password',
        ]);
    }
    public static function userStore($request)
    {
        return $request->validate([
            'name' => 'required|max:50',
            'username' => 'required|string|max:15|min:3|unique:users|regex:/^\S*$/u',
            'province_id' => 'required',
            'district_id' => 'required',
            'ward_id' => 'required',
            'street' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|digits:10|regex:/^0/|unique:users,phone',
            'password' => 'required|min:8',
            'confirm_password' => 'bail|required|same:password',
        ]);
    }

    public static function userUpdate($request, $id)
    {
        return $request->validate([
            'name' => 'required|max:50',
            'username' => 'required|string|max:15|min:3|regex:/^\S*$/u|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|digits:10|regex:/^0/|unique:users,phone,' . $id,
        ]);

        if ($request->has('changepass')) {
            return $request->validate([
                'password' => 'required|min:8',
                'confirm_password' => 'bail|required|same:password',
            ]);
        }
    }

    public static function categoryValidation($request, $id = null)
    {
        if ($id != null) {
            return $request->validate([
                'name' => 'required|min:3|max:50|unique:categories,id,' . $id,
            ]);
        } else {
            return $request->validate([
                'name' => 'required|min:3|max:50|unique:categories',
            ]);
        }
    }
    public static function reviewCreate($request)
    {
        return $request->validate([
            'seller_id' => 'required',
            'customer_id' => 'required',
            'star' => 'required',
            'content' => 'required|max:255',
        ]);
    }

    public static function productValidation($request, $id = null)
    {
        $filter = [
            'title' => 'required|string|min:5|max:255',
            'seller_id' => 'required',
            'seller_address' => 'required',
            'category_id' => 'required',
            'attributes' => 'required',
            'price' => 'required|',
            'status' => 'required',
            'desc' => 'required',
            'image' => 'required'
        ];
        if ($id != null) {
            unset($filter['image']);
        }
        return $request->validate($filter);
    }

    public static function createRole($request)
    {
        return $request->validate([
            'name' => 'required|max:50|min:3'
        ]);
    }

    public static function buyNowValidation($request)
    {
        return $request->validate([
            'customer_address' => 'required'
        ]);
    }
}
