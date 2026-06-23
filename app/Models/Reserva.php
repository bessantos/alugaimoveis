<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'casa_id', 'check_in', 'check_out'];

    // Uma reserva pertence a um usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Uma reserva pertence a uma casa
    public function casa()
    {
        return $this->belongsTo(Casa::class);
    }
}