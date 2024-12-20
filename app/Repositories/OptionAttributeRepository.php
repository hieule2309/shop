<?php
namespace App\Repositories;
use App\Interfaces\OptionAttributeRepositoryInterface;
use App\Models\OptionAttribute;
class OptionAttributeRepository implements OptionAttributeRepositoryInterface{

    public function getByProduct($id){
        $attributes = OptionAttribute::where('product_id', $id)->get();
        return $attributes;
    }
    
    public function getByOption($id){
        $attributes = OptionAttribute::where('option_id', $id)->get();
        return $attributes;
    }
    
    public function find($id){
        $attribute = OptionAttribute::find($id);
        return $attribute;
    }

    public function create(array $data){
        return OptionAttribute::create($data);
    }
    
    public function update($id, array $data){
        $attribute = $this->find($id);
        $attribute = $attribute->update($data);
        return $attribute;
    }
    
    public function delete($id){
        $attribute = $this->find($id);
        return $attribute->delete();
    }

}