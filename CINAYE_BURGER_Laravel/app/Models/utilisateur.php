<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class utilisateur extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasFactory;
    protected $table = 'utilisateur';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'Prenom',
        'Nom',
        'Email',
        'Mot_de_passe',
    ];

   
}
