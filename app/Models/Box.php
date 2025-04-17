<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pension;
use App\Models\Tarification;

class Box extends Model
{
    use HasFactory;

    protected $table = 'boxes';
    
    protected $fillable = [
        'numero',
        'taille',
        'type',
        'disponibilite',
        'tarification_id'
    ];

    protected $casts = [
        'disponibilite' => 'boolean',
        'tarification_id' => 'integer'
    ];

    public function tarification()
    {
        return $this->belongsTo(Tarification::class);
    }

    public function pension()
    {
        return $this->belongsTo(Pension::class)->through('tarification');
    }
}
