<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pension extends Model
{
    public function tarifsCatalogue()
    {
        return $this->hasMany(\App\Models\TarifCatalogue::class, 'pension_id');
    }
    use HasFactory;

    public $timestamps = false;
    protected $table = 'pension';

    protected $fillable = [
        'Ville',
        'Adresse',
        'Responsable',
        'Telephone'
    ];

    public function boxes()
    {
        return $this->hasMany(Box::class);
    }
}
