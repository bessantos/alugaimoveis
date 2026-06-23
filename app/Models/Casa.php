<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Casa extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'descricao', 'preco', 'endereco', 'imagem', 'user_id'];

    // Uma casa pertence a um usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Uma casa pode ter várias reservas
    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}