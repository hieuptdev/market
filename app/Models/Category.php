<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name', 'parent_id'
    ];

    public function rootCategory()
    {
        return $this->where('parent_id', 0)->get();
    }

    public function attribute()
    {
       return $this->hasMany('App\Models\Attribute', 'category_id', 'id'); 
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'id', 'category_id');
    }

    public function childCategory($id)
    {
        return $this->where('parent_id', $id)->get();
    }

    public function findCategory($id)
    {
        return $this->find($id);
    }

    public function allCategory()
    {
        return $this->all();
    }

    public function getListCategory($data)
    {
        $categories = $this->Query();
        $search = isset($data['search']) ? $data['search'] : '';
        $categories->where(function ($query) use ($search) {
            $query
            ->where('name', 'like', '%' . $search . '%')
            ->orwhereHas('attribute', function($query) use ($search){
                $query->where('name', 'like', '%' . $search . '%');
            });
        });
        if (isset($data['root'])) {
            $categories->where('parent_id', $data['root']);
        }
        if (isset($data['sort'])) {
            $sort = $data['sort'];
            if ($sort == 'idasc') {
                $categories->orderBy('id', 'ASC');
            }
            if ($sort == 'iddesc') {
                $categories->orderBy('id', 'DESC');
            }
            if ($sort == 'nameasc') {
                $categories->orderBy('name', 'ASC');
            }
            if ($sort == 'namedesc') {
                $categories->orderBy('name', 'DESC');
            }
            if($sort == 'createasc'){
                $categories->orderBy('created_at', 'ASC');
            }
            if($sort == 'createdesc'){
                $categories->orderBy('created_at', 'DESC');
            }
        }
        return $categories->paginate(numberPerPage());
    }

    public function saveData($data, $id = null)
    {
        if (!$id) {
            $category = new $this;
            $category->fill($data)->save();
            return $category->id;
        } else {
            $category = $this->find($id);
            return $category->fill($data)->save();
        }
    }

    public function rootName($id)
    {
        return $this->where('id', $id)->pluck('name')->first();
    }

    public function deleteCategory($id)
    {
        $category = $this->find($id);
        return $category->delete();
    }
}
