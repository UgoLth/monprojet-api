<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TarifCatalogue extends Model
{
    protected $table = 'tarif_catalogues';
    protected $fillable = ['pension_id', 'catalogue_id', 'prix'];
    public $timestamps = false;

    public function pension()
    {
        return $this->belongsTo(Pension::class, 'pension_id');
    }

    public function catalogue()
    {
        return $this->belongsTo(Catalogue::class, 'catalogue_id');
    }
}
