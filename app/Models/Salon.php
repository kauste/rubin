<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
    use HasFactory;
    public function master(){
        return $this->hasMany(Model::class, 'salon_id', 'id'); // o kodel dvejose vietose ta pati sakom?
    }
}
