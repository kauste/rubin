<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apointment extends Model
{
    use HasFactory;

    public function procedure(){
        return $this->belongsTo(Procedure::class, 'procedure_id', 'id');  
    }
    public function master(){
        return $this->hasMany(Master::class, 'master_id', 'id') ;     
    }
}
