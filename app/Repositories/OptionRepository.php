<?php

namespace App\Repositories;

use App\Interfaces\OptionRepositoryInterface;
use App\Models\Option;

class OptionRepository implements OptionRepositoryInterface
{

    public function getAllOptionsProduct($id)
    {
        // Logic to retrieve all options
        $options = Option::where('product_id', $id)->get();
        return $options;
    }

    public function find($id)
    {
        // Logic to retrieve an option by ID
        $option = Option::find($id);
        return $option;
    }

    public function create(array $data)
    {
        // Logic to create a new option
        return Option::create($data);
    }

    public function update($id, array $data)
    {
        // Logic to update an existing option
        $option = $this->find($id);
        $option = $option->update($data);
        return $option;
    }

    public function delete($id)
    {
        // Logic to delete an option
        $option = $this->find($id);
        return $option->delete();
    }

}
