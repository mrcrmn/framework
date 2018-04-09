<?php

namespace App\Models;

use Framework\Database\Model;

class Product extends Model
{
    protected $table = 'products';

    public function lowercase()
    {
        return strtolower($this->name);
    }
}