<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Master;

class Procedure extends Model
{
    use HasFactory;
    public function masters(){
        return $this->hasMany(Master::class, 'master_id', 'id');
    }
    
}
