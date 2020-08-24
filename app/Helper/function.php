<?php

use Illuminate\Support\Facades\Auth;

function showError($errors, $nameInput)
{
    if ($errors->has($nameInput)) {
        echo '<div class="alert alert-danger" role="alert">';
        echo '<strong>' . $errors->first($nameInput) . '</strong>';
        echo '</div>';
    }
}

function checkPermission($permission)
{
    if (!Auth::guard('admin')->User()->role == NULL) {
        $list_permission = Auth::guard('admin')->User()->role->permission->pluck(['slug'])->all();
        if (in_array($permission, $list_permission)) {
            return true;
        }
    } else {
        return false;
    }
}


function numberPerPage()
{
    return 8;
}

function homePage()
{
    return 12;
}

function totalBought($id)
{
    return \App\Models\product::where('customer_id', $id)->where('status', \App\Models\Product::DELIVERED)->count();
}

function totalSold($id)
{
    return \App\Models\product::where('seller_id', $id)->where('status', \App\Models\Product::DELIVERED)->count();
}

function totalReview($id)
{
    return \App\Models\Review::where('seller_id', $id)->count();
}

function statusProduct()
{
    return [
        [
            'name' => 'Pending',
            'number' => 1,
        ],
        [
            'name' => 'Active',
            'number' => 2,
        ],
        [
            'name' => 'Pending approval',
            'number' => 3,
        ],
        [
            'name' => 'Shipping',
            'number' => 4,
        ],
        [
            'name' => 'Delivered',
            'number' => 5,
        ],
        [
            'name' => 'Canceled',
            'number' => 6,
        ],
        [
            'name' => 'Deleted',
            'number' => 7,
        ],
    ];
}

function getStatusName($number)
{
    $allStatus = statusProduct();
    return $allStatus[$number - 1]['name'];
}

function sidebar()
{
    return [
        'user' => [
            'name' => 'User',
            'routeName' => ['user.create', 'user.index', 'user.edit'],
            'icon' => 'fa fa-users',
            'child' => [
                [
                    'name' => 'List',
                    'icon' => 'fa fa-list-alt',
                    'url' => route('user.index'),
                    'routeName' => 'user.index',
                ],
                [
                    'name' => 'Create',
                    'icon' => 'fa fa-plus',
                    'url' => route('user.create'),
                    'routeName' => 'user.create',
                ]
            ],
        ],

        'admin' => [
            'name' => 'Admin',
            'routeName' => ['admin.list', 'admin.create', 'admin.edit'],
            'icon' => 'fa fa-unlock',
            'child' => [
                [
                    'name' => 'List',
                    'icon' => 'fa fa-list-alt',
                    'url' => route('admin.list'),
                    'routeName' => 'admin.list',
                ],
                [
                    'name' => 'Create',
                    'icon' => 'fa fa-plus',
                    'url' => route('admin.create'),
                    'routeName' => 'admin.create',
                ]
            ],
        ],

        'product' => [
            'name' => 'Product',
            'routeName' => ['product.create', 'product.index', 'product.edit'],
            'icon' => 'fa fa-product-hunt',
            'child' => [
                [
                    'name' => 'List',
                    'icon' => 'fa fa-list-alt',
                    'url' => route('product.index'),
                    'routeName' => 'product.index',
                ],
                [
                    'name' => 'Create',
                    'icon' => 'fa fa-plus',
                    'url' => route('product.create'),
                    'routeName' => 'product.create',
                ]
            ],
        ],

        'category' => [
            'name' => 'Category',
            'routeName' => ['category.create', 'category.index', 'category.edit'],
            'icon' => 'fa fa-calendar-times-o',
            'child' => [
                [
                    'name' => 'List',
                    'icon' => 'fa fa-list-alt',
                    'url' => route('category.index'),
                    'routeName' => 'category.index',
                ],
                [
                    'name' => 'Create',
                    'icon' => 'fa fa-plus',
                    'url' => route('category.create'),
                    'routeName' => 'category.create',
                ]
            ],
        ],

        'role' => [
            'name' => 'Role',
            'routeName' => ['review.create', 'role.index', 'role.edit'],
            'icon' => 'fas fa-rocket',
            'child' => [
                [
                    'name' => 'List',
                    'icon' => 'fa fa-list-alt',
                    'url' => route('role.index'),
                    'routeName' => 'role.index',
                ],
                [
                    'name' => 'Create',
                    'icon' => 'fa fa-plus',
                    'url' => route('role.create'),
                    'routeName' => 'role.create',
                ]
            ],
        ],


        'review' => [
            'name' => 'Review',
            'routeName' => ['review.create', 'review.index', 'review.edit'],
            'icon' => 'fas fa-star',
            'child' => [
                [
                    'name' => 'List',
                    'icon' => 'fa fa-list-alt',
                    'url' => route('review.index'),
                    'routeName' => 'review.index',
                ],
                [
                    'name' => 'Create',
                    'icon' => 'fa fa-plus',
                    'url' => route('review.create'),
                    'routeName' => 'review.create',
                ]
            ],
        ],



    ];
}

// function checkUserPermission($permission)
// {
//     // if (Auth::guard('admin')->user()->role != NULL) {
//     $user = Auth::guard('admin')->user();
//     $role = Role::find($user->role_id);
//     $list_permission = $role->permission->pluck('slug')->all();
//     if (in_array($permission, $list_permission)) {
//         return true;
//     }
//     // }
//     // return false;
// }
