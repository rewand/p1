<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id', 'caregiver_id', 'photo_1', 'photo_2', 'regist_date', 'regist_status'];
    protected $hidden = ['created_at', 'updated_at', 'regist_status'];

    // Relación con la categoría
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Relación con el cuidador
    public function caregiver()
    {
        return $this->belongsTo(Caregiver::class, 'caregiver_id');
    }

    // Relación con los alimentos
    public function feeds()
    {
        return $this->belongsToMany(Feed::class, 'animals_feeds', 'animal_id', 'feed_id');
    }

}
