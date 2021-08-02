<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitoria extends Model
{
    use HasFactory;

    protected $fillable = ['disciplina', 'conteudo', 'data_horario', 'local', 'monitor', 'descricao', 'num_inscritos'];
}