<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Appartenir1 extends Pivot
{
    use HasFactory;

    protected $table = 'appartenir1';

    public $timestamps = false;
}
