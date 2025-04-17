<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Appartenir3 extends Pivot
{
    use HasFactory;

    protected $table = 'appartenir3'; // Nom exact de la table MySQL

    public $timestamps = false; // Pas de created_at / updated_at

    protected $fillable = [
        'Animal_id',
        'Proprietaire_id'
    ];
}
