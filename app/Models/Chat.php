<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chat';

    protected $fillable = [
        'usuario_id', 'tipo', 'assunto', 'linha', 'chat_status'
    ];

    public $timestamps = false;

    const CREATED_AT = 'criado_em';
}
