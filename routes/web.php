<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

//Backend
Route::get('admin-login', 'Backend\AdminController@getLogin')->middleware('CheckAdminLogout')->name('admin.get.login');
Route::post('admin-login', 'Backend\AdminController@postLogin')->name('admin.post.login');
Route::get('admin-logout', 'Backend\AdminController@logout')->name('admin.logout');
Route::group(['prefix' => 'admin', 'namespace' => 'Backend', 'middleware' => 'CheckAdminLogin'], function () {
    //Admin
    Route::get('list', 'AdminController@listAdmin')->name('admin.list');
    Route::get('add', 'AdminController@createAdmin')->name('admin.create');
    Route::post('add', 'AdminController@storeAdmin')->name('admin.store');
    Route::get('edit/{id}', 'AdminController@editAdmin')->name('admin.edit');
    Route::post('edit/{id}', 'AdminController@updateAdmin')->name('admin.update');
    Route::delete('delete/{id}', 'AdminController@deleteAdmin')->name('admin.delete');


    //Product
    Route::resource('product', 'ProductController');
    Route::get('product/confirm/{id}', 'ProductController@confirmProduct')->name('product.confirm');
    Route::resource('category', 'CategoryController');
    Route::get('/', 'AdminController@index')->name('admin.home');
    //User
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'UserController@index')->name('user.index');
        Route::get('add', 'UserController@create')->name('user.create');
        Route::post('add', 'UserController@store')->name('user.store');
        Route::get('address/{id}', 'UserController@address')->name('user.address');
        Route::get('edit/{id}', 'UserController@edit')->name('user.edit');
        Route::put('edit/{id}', 'UserController@update')->name('user.update');
        Route::delete('delete/{id}', 'UserController@delete')->name('user.delete');
    });
    //Review
    Route::group(['prefix' => 'review'], function () {
        Route::get('', 'ReviewController@index')->name('review.index');
        Route::get('add', 'ReviewController@create')->name('review.create');
        Route::get('edit/{id}', 'ReviewController@edit')->name('review.edit');
        Route::post('edit/{id}', 'ReviewController@update')->name('review.update');
        Route::get('delete/{id}', 'ReviewController@destroy')->name('review.delete');
        Route::post('add', 'ReviewController@store')->name('review.store');
        Route::post('customer', 'ReviewController@getCustomer')->name('review.customer');
    });

    Route::group(['prefix' => 'role'], function () {
        Route::get('', 'RoleController@index')->name('role.index');
        Route::get('add', 'RoleController@create')->name('role.create');
        Route::post('add', 'RoleController@store')->name('role.store');
        Route::get('edit/{id}', 'RoleController@edit')->name('role.edit');
        Route::post('edit/{id}', 'RoleController@update')->name('role.update');
        Route::delete('delete/{id}', 'RoleController@destroy')->name('role.delete');
    });
});

Auth::routes(['verify' => true]);
Route::post('ajax-get-districts', 'AjaxController@getDistricts')->name('get.districts');
Route::post('ajax-get-ward', 'AjaxController@getWards')->name('get.wards');
Route::post('ajax-get-user-address', 'AjaxController@getUserAddress')->name('ajax.get.address');
Route::post('ajax-get-attributes', 'AjaxController@getAttribute')->name('ajax.get.attributes');
Route::get('ajax-approve-product', 'AjaxController@approveProduct')->name('ajax.approve.product');
Route::post('ajax-create-review', 'AjaxController@createreview')->name('ajax.create.review');
Route::group(['namespace' => 'Frontend', 'middleware' => 'verified'], function () {
    //Home
    Route::get('', 'HomeController@index')->name('index');
    Route::get('category/{id}', 'HomeController@productByCategory')->name('frontend.product.category');

    //Product
    Route::group(['prefix' => 'product'], function () {
        Route::get('', 'ProductController@index')->name('frontend.product.index');
        Route::get('detail/{id}', 'ProductController@detail')->name('frontend.product.detail');
        Route::get('add', 'ProductController@create')->name('frontend.product.create');
        Route::post('add', 'ProductController@store')->name('frontend.product.store');
        Route::get('edit/{id}', 'ProductController@edit')->name('frontend.product.edit')->middleware('SellerProduct');
        Route::delete('destroy/{id}', 'ProductController@destroy')->name('frontend.product.destroy')->middleware('SellerProduct');
        Route::post('update/{id}', 'ProductController@update')->name('frontend.product.update')->middleware('SellerProduct');;
    });

    Route::get('user/account/profile', 'UserController@showProfile')->name('user.account.profile');
    Route::post('user/account/profile', 'UserController@editProfile')->name('user.account.edit.profile');
    Route::post('user/account/verify/password', 'UserController@verifyPassword')->name('user.account.verify.password');
    Route::get('user/account/phone', 'UserController@getChangePhone')->name('user.account.change.phone');
    Route::post('user/account/phone', 'UserController@postChangePhone')->name('user.account.change.phone');
    Route::get('user/account/email', 'UserController@getChangeEMail')->name('user.account.change.email');
    Route::post('user/account/email', 'UserController@postChangeEMail')->name('user.account.change.email');
    Route::get('user/account/password', 'UserController@getChangePassword')->name('user.account.password');
    Route::post('user/account/password', 'UserController@postChangePassword')->name('user.account.change.password');
    Route::get('user/account/address', 'UserController@getAddress')->name('user.account.address');
    Route::post('user/account/address/create', 'UserController@addAddress')->name('user.account.address.create');
    Route::post('user/account/address/default', 'UserController@changeDefaultAddress')->name('user.account.address.default');
    Route::post('user/account/address/delete', 'UserController@deleteAddress')->name('user.account.address.delete');
    Route::post('user/account/address/edit', 'UserController@editAddress')->name('user.account.address.edit');
    Route::post('user/account/address/update', 'UserController@updateAddress')->name('user.account.address.update');
    // User product

    Route::get('user/product', 'UserController@getListProduct')->name('user.product');
    Route::get('user/product/pending-approval', 'UserController@getListProductPendingApproval')->name('user.product.pending.approval');
    Route::get('user/product-approval/cancel/{id}', 'UserController@cancelProductPendingApproval')
        ->name('user.product.pending.approval.cancel')->middleware('SellerProduct');
    Route::get('user/product-approval/confirm/{id}', 'UserController@confirmProductPendingApproval')
        ->name('user.product.pending.approval.confirm')->middleware('SellerProduct');
    // User purchase

    Route::get('user/purchase', 'UserController@getListPurchase')->name('user.purchase');
    Route::get('user/product/buy-now/{id}', 'UserController@getBuyNow')->name('user.product.get.buy');
    Route::post('user/product/buy-now/{id}', 'UserController@postBuyNow')->name('user.product.post.buy');
    Route::get('user/product/delete/{id}', 'UserController@deleteProduct')->name('user.product.delete')->middleware('SellerProduct');
    Route::get('user/purchase/cancel/{id}', 'UserController@cancelPurchase')->name('user.purchase.cancel')->middleware('CustomerProduct');
    Route::get('user/purchase/complete/{id}', 'UserController@completePurchase')->name('user.purchase.complete')->middleware('SellerProduct');
});
