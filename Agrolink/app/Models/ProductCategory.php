<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'tb_product_categories';
    protected $primaryKey = 'id_categorie';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'category_name',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'id_category', 'id_categorie');
    }
}
