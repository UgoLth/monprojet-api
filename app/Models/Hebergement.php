<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hebergement extends Model
{
    use HasFactory;

    protected $table = 'hebergement';
    protected $fillable = ['pension_id', 'typegardiennage_id', 'tarif'];

    public function pension()
    {
        return $this->belongsTo(Pension::class);
    }

    public function typeGardiennage()
    {
        return $this->belongsTo(TypeGardiennage::class, 'typegardiennage_id');
    }

    public function boxes()
    {
        return $this->hasMany(Box::class);
    }
}
