<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getCompany()
    {
    return $this->company_name;
    }

    public function getAllCompanies() {

        $companies = $this->all();

        return $companies;
    }
}
