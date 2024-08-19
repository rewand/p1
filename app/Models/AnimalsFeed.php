<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalsFeed extends Model
{
    use HasFactory;

    protected $table = 'animals_feeds';
    protected $fillable = ['animal_id', 'feed_id',];
    protected $hidden = ['created_at', 'updated_at'];

    // Define las relaciones si es necesario
    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }

    public function feed()
    {
        return $this->belongsTo(Feed::class, 'feed_id');
    }
}
