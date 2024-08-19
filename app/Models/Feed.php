<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    use HasFactory;

    protected $table = 'feeds';

    protected $fillable = ['name'];
    protected $hidden = ['created_at', 'pivot', 'updated_at'];


    // Define las relaciones si es necesario
    public function animalsFeeds()
    {
        return $this->hasMany(AnimalsFeed::class, 'feed_id');
    }
}
