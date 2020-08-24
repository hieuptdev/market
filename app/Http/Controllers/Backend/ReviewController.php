<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Review, User, Product};
use App\Validation\Validation;

class ReviewController extends Controller
{
    public function __construct(User $user, Review $review, Product $product)
    {
        $this->user = $user;
        $this->review = $review;
        $this->product = $product;
    }

    public function index(Request $request)
    {
        if (!checkPermission('review-read')) {
            return redirect()->route('admin.home')->with('noti', 'Not Permission')->with('status', 'danger');
        }
        $reviews = $this->review->getReview($request->all());
        return view('backend.review.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Responsecustomer
     */
    public function create(Request $request)
    {
        if (!checkPermission('review-read') || !checkPermission('review-create') || !checkPermission('review-edit') || !checkPermission('review-delete')) {
            return redirect()->route('admin.home')->with('noti', 'Not Permission')->with('status', 'danger');
        }
        $users = $this->user->getAllUser();
        return view('backend.review.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validation::reviewCreate($request);
        if ($this->review->saveDataReview($request->all())) {
            $this->user->updateAvgRate($request->seller_id, $this->review->getAvgStar($request->seller_id));
            return redirect()->route('review.index')->with('noti', 'Success Create')->with('status', 'success');
        }
        return redirect()->route('review.index')->with('noti', 'Create fail')->with('status', 'danger');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!checkPermission('review-read') || !checkPermission('review-create') || !checkPermission('review-edit') || !checkPermission('review-delete')) {
            return redirect()->route('admin.home')->with('noti', 'Not Permission')->with('status', 'danger');
        }
        // $review = $this->review->getReview($id);
        $users = $this->user->getAllUser();
        $customers = $this->user->getAllUser();
        return view('backend.review.edit', compact('users', 'review', 'customers'));
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
        Validation::reviewCreate($request);
        $reviews = $this->review->saveDataReview($request->all(), $id);
        return redirect()->route('review.index')->with('noti', 'Success Edit')->with('status', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!checkPermission('review-read') || !checkPermission('review-create') || !checkPermission('review-edit') || !checkPermission('review-delete')) {
            return redirect()->route('admin.home')->with('noti', 'Not Permission')->with('status', 'danger');
        }
        $review = $this->review->delReview($id);
        return back()->with('noti', 'Delete Success')->with('status', 'success');
    }

    public function getCustomer(Request $request)
    {
        $customers = $this->user->getAllUser($request->id);
        $products = $this->product->getListProductHaveNoCustomer();
        return response()->json(['customers' => $customers, 'products' => $products]);
    }
}
