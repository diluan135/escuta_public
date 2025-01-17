<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opcoes extends Model
{
    protected $table = 'opcoes_enquete';

    protected $fillable = [
        'enquete_id',
        'opcao',
    ];

    public $timestamps = false;
}
