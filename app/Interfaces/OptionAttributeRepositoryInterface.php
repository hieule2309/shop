<?php

namespace App\Interfaces;

interface OptionAttributeRepositoryInterface
{
    public function getByProduct($id);
    
    public function getByOption($id);

    public function find($id);
    
    public function create(array $data);
    
    public function update($id, array $data);
    
    public function delete($id);
}
