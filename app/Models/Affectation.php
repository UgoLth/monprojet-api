<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affectation extends Model
{
    use HasFactory;

    protected $table = 'affectation'; // Nom exact de ta table MySQL
    public $timestamps = false; // Désactive created_at et updated_at
    protected $fillable = [
        'animal_id',
        'DateFin',
        'Regle',
        'CarnetVaccination',
        'Poids',
        'Age',
        'VaccinAJour',
        'VermifugeAJour',
    ];

    protected $casts = [
        'DateFin' => 'date',
        'VaccinAJour' => 'boolean',
        'VermifugeAJour' => 'boolean',
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }
    public function boxes()
    {
        return $this->belongsToMany(Box::class, 'affectation_box', 'Affectation_id', 'Box_id')->using(AffectationBox::class);
    }
}
