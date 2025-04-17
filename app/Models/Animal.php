<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Animal extends Model
{
    use HasFactory;

    protected $table = 'animals';
    
    public $timestamps = true;

    protected $fillable = [
        'nom',
        'race',
        'date_naissance',
        'espece_id',
        'proprietaire_id',
        'age',
        'poids'
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'age' => 'integer',
        'poids' => 'decimal:2',
        'espece_id' => 'integer',
        'proprietaire_id' => 'integer'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function espece()
    {
        return $this->belongsTo(Espece::class);
    }

    public function proprietaire()
    {
        return $this->belongsTo(Proprietaire::class);
    }
}
