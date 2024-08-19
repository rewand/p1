<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caregiver extends Model
{
    use HasFactory;

    protected $fillable = ['docu_type_id', 'name', 'surnames', 'num_docu', 'regist_status'];
    protected $hidden = ['created_at', 'updated_at', 'regist_status'];
    // Relación con el tipo de documento
    public function documentType()
    {
        return $this->belongsTo(DocumentType::class, 'docu_type_id');
    }

    // Relación con los animales
    public function animals()
    {
        return $this->hasMany(Animal::class, 'caregiver_id');
    }
}
