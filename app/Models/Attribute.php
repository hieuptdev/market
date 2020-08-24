<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table = 'attributes';

    protected $fillable = [
    	'category_id', 'name', 'type', 'values'
    ];

    public function saveData($data, $attributeId = null, $category_id = null)
    {
        if($attributeId != null){
            $allAttr = $this->where('category_id', $category_id)->pluck('id')->toArray();
            $numAttrId = count($attributeId);
            $numAttr = count($data);
            $arrDiff = array_diff($allAttr, $attributeId);
            for ($i = 0; $i < $numAttrId ; $i++) {
                $attribute = $this->find($attributeId[$i]);
                $attribute->fill($data[$i])->save();
            }
            if($arrDiff != []){
                $this->destroy($arrDiff);
            }
            if($numAttr > $numAttrId){
                for ($i = $numAttrId; $i < $numAttr; $i++) {
                    $attribute = new $this;
                    $attribute->fill($data[$i])->save();
                }
            }
        }else{
            $loop = count($data);
            for ($i = 0; $i < $loop ; $i++) {
                $attribute = new $this;
                $attribute->fill($data[$i])->save();
            }
        }
    }

    public function allAttribute()
    {
    	return $this->all();
    }

    public function categoryAttribute($category)
    {
        return $this->where('category_id', $category)->get();
    }

    public function deleteAtribute($id)
    {
       $attrAttr= $this->where('category_id',$id)->pluck('id')->toArray();
       return $this->destroy($attrAttr);
    }
    
}
