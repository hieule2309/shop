<?php

namespace App\Interfaces;

interface OptionRepositoryInterface
{
    public function getAllOptionsProduct($id);
    
    public function find($id);
    
    public function create(array $data);
    
    public function update($id, array $data);
    
    public function delete($id);
}
