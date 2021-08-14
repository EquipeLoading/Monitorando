<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitoria extends Model
{
    use HasFactory;

    protected $fillable = ['codigo', 'disciplina', 'conteudo', 'data', 'hora_inicio', 'hora_fim', 'local', 'monitor', 'descricao', 'num_inscritos', 'user_id'];

    public function usuarios() {
        return $this->belongsToMany(User::class);
    }
}