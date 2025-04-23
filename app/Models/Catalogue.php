<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalogue extends Model
{
    protected $table = 'catalogues';
    protected $fillable = ['nom'];
    public $timestamps = false;

    public function tarifs()
    {
        return $this->hasMany(TarifCatalogue::class, 'catalogue_id');
    }
}
