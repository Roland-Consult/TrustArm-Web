<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    public function escrow()
    {
        return $this->belongsTo(Escrow::class,'escrow_id','id');
    }

    public function message()
    {
        return $this->hasMany(Message::class);
    }
}
