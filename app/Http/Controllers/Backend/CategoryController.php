<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Attribute;
use App\Validation\Validation;

class CategoryController extends Controller
{

    public $category;
    public $attribute;

    public function __construct(Category $category, Attribute $attribute)
    {
        $this->category = $category;
        $this->attribute = $attribute;
    }

    public function index(Request $request)
    {
        if (!checkPermission('category-read')) {
            return redirect()->route('admin.home')->with('noti', 'Not Permission')->with('status', 'danger');
        }
        $categories = $this->category->getListCategory($request->all());
        $rootCategory = $this->category->rootCategory();
        return view('backend.category.index', compact('categories', 'rootCategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!checkPermission('category-read') || !checkPermission('category-create') || !checkPermission('category-edit') || !checkPermission('category-delete')) {
            return redirect()->route('admin.home')->with('noti', 'Not Permission')->with('status', 'danger');
        }
        $categories = $this->category->rootCategory();
        return view('backend.category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validation::categoryValidation($request);
        $result = $this->category->saveData($request->all());
        $arrAttr = [];
        if ($result) {
            if ($request->has('attributes')) {
                $numAttr = count($request->input('attributes.name'));
                for ($i = 0; $i < $numAttr; $i++) {
                    $data['category_id'] = $result;
                    $data['name'] = $request->input('attributes.name.' . $i . '');
                    $data['type'] = $request->input('attributes.type.' . $i . '');
                    $data['values'] = $request->input('attributes.values.' . $i . '');
                    array_push($arrAttr, $data);
                }
                $this->attribute->saveData($arrAttr);
            }
            return redirect()->route('category.index')->with('success', 'Create category success fully!');
        }
        return back()->with('error', 'Something went wrong, please try again!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!checkPermission('category-read') || !checkPermission('category-create') || !checkPermission('category-edit') || !checkPermission('category-delete')) {
            return redirect()->route('admin.home')->with('noti', 'Not Permission')->with('status', 'danger');
        }
        $editCategory = $this->category->findCategory($id);
        $categories = $this->category->rootCategory();
        return view('backend.category.edit', compact('editCategory', 'categories'));
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
        Validation::categoryValidation($request, $id);
        $allAttr = $this->attribute->categoryAttribute($id);
        if ($this->category->saveData($request->all(), $id)) {
            if ($request->has('attributes')) {
                $attributeId = $request->input('attributes.attributeId');
                $arrAttr = [];
                $numAttr = count($request->input('attributes.name'));
                for ($i = 0; $i < $numAttr; $i++) {
                    $data['category_id'] = $request->input('category_id');
                    $data['name'] = $request->input('attributes.name.' . $i . '');
                    $data['type'] = $request->input('attributes.type.' . $i . '');
                    $data['values'] = $request->input('attributes.values.' . $i . '');
                    array_push($arrAttr, $data);
                }

                $this->attribute->saveData($arrAttr, $attributeId, $id);
                return redirect()->route('category.index')->with('success', 'Edit category success fully!');
            } else {
                $this->attribute->deleteAtribute($id);
                return redirect()->route('category.index')->with('success', 'Edit category success fully!');
            }
        }
        return back()->with('error', 'Something went wrong, please try again!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!checkPermission('category-read') || !checkPermission('category-create') || !checkPermission('category-edit') || !checkPermission('category-delete')) {
            return redirect()->route('admin.home')->with('noti', 'Not Permission')->with('status', 'danger');
        }
        if ($this->category->deleteCategory($id)) {
            return redirect()->route('category.index')->with('success', 'Delete category success fully!');
        }
        return redirect()->route('category.index')->with('error', 'Something went wrong, please try again!');
    }
}
