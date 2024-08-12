<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandeModel extends Model
{
    use HasFactory;
    protected $table = 'commande';
    
    protected $fillable = [
        'Utilisateur',
        'Burger',
        
        
    ];
    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'Utilisateur');
    }

    public function burger()
    {
        return $this->belongsTo(BurgersModel::class, 'Burger');
    }
}
