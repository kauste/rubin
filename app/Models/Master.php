<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Salon;
use App\Models\Procedure;

class Master extends Model
{
    use HasFactory;
    public function salon(){
        return $this->belongsTo(Salon::class, 'salon_id', 'id'); // o kodel dvejose vietose ta pati sakom?
    }
    public function procedures(){
        return $this->hasMany(Procedure::class, 'master_id', 'id');
    }
}
