<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id', 'regist_status'];

    protected $hidden = ['created_at', 'updated_at', 'regist_status'];

    // Relación con los animales
    public function animals()
    {
        return $this->hasMany(Animal::class, 'category_id');
    }

    // Relación con la categoría padre
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Relación con las categorías hijas
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
