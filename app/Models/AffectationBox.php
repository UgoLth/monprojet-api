<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AffectationBox extends Pivot
{
    use HasFactory;

    protected $table = 'affectation_box';

    public $timestamps = false;
}
