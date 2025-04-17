<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Espece extends Model
{
    use HasFactory;

    protected $table = 'especes';
    
    protected $fillable = [
        'nom'
    ];

    public function animaux()
    {
        return $this->hasMany(Animal::class);
    }
}
