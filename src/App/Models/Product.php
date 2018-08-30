<?php

namespace App\Models;

use Framework\Database\Model;

class Product extends Model
{

    public function getTable()
    {
        return 'products';
    }
    
    public function lowercase()
    {
        return strtolower($this->name);
    }
}