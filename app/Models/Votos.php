<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Votos extends Model
{
    protected $table = 'votos';

    protected $fillable = [
        'usuario_id',
        'enquete_id',
        'opcao_id',
    ];

    public $timestamps = false;

    const CREATED_AT = 'voto_em';

}
