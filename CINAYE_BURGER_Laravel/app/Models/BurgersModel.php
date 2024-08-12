<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BurgersModel extends Model
{

    use HasFactory;
    protected $table = 'burgers';

    protected $fillable = [
        'Nom',
        'Prix',
        'Image',
        'Description',
    ];
}
