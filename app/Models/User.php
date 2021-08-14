<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{ 
    use HasFactory, Notifiable;

    protected $fillable = ['nome', 'email', 'prontuario', 'senha', 'disciplinas', 'tipo', 'turma_id'];

    protected $hidden = ['prontuario', 'senha'];

    protected $casts = ['email_verified_at' => 'datetime'];

    public function monitorias() {
        return $this->belongsToMany(Monitoria::class);
    }
}
