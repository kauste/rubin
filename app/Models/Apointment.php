<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apointment extends Model
{
    use HasFactory;

    const STATES = [
        1 => 'New',
        2 => 'Accepted',
        3 => 'Canceled',
        4 => 'Finished',
        5 => 'Did not come',
        6 => 'Client canceled'
    ];

    public function procedure(){
        return $this->belongsTo(Procedure::class, 'procedure_id', 'id');  
    }
    public function master(){
        return $this->hasMany(Master::class, 'master_id', 'id') ;     
    }
}
