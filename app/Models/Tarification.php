<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarification extends Model
{
    use HasFactory;

    protected $table = 'tarification'; // Table existante

    public $timestamps = false;

    protected $fillable = [
        'TypeGardiennage_id',
        'Tarif',
        'pension_id'
    ];

    public function pension()
    {
        return $this->belongsTo(Pension::class);
    }

    public function boxes()
    {
        return $this->hasMany(Box::class);
    }
}
