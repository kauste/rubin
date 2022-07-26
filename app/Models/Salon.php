<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Master;

class Salon extends Model
{
    use HasFactory;
    public function masters(){
        return $this->hasMany(Master::class, 'salon_id', 'id');
    }
}
