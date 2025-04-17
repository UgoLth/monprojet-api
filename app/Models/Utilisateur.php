<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Utilisateur extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'utilisateurs'; // Vérifie bien que la table s'appelle 'utilisateurs'

    protected $fillable = [
        'nom',
        'email',
        'password',
    ];

    protected $hidden = [ 'remember_token'];

    public $timestamps = false;

    // Mutateur pour hacher le mot de passe automatiquement
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
