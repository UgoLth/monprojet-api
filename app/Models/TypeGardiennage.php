<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeGardiennage extends Model
{
    use HasFactory;

    protected $table = 'typegardiennage'; // Nom exact de la table MySQL

    public $timestamps = false; // Désactive created_at et updated_at

    protected $fillable = [
        'Libelle'
    ];

    public function tarifications()
    {
        return $this->hasMany(Tarification::class, 'TypeGardiennage_id');
    }

    public function boxes()
    {
        return $this->belongsToMany(Box::class, 'box_typegardiennage', 'TypeGardiennage_id', 'Box_id')->using(BoxTypeGardiennage::class);
    }

}
