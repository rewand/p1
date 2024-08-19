<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory;

    protected $table = 'document_type'; // Asegúrate de que el nombre de la tabla sea correcto

    protected $fillable = ['name',];
    protected $hidden = ['created_at', 'updated_at'];

    // Define las relaciones si es necesario
    public function caregivers()
    {
        return $this->hasMany(Caregiver::class, 'docu_type_id');
    }
}
