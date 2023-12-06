<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bucket extends Model
{
    use HasFactory;
    
    protected $fillable = ['capacity', 'current_capacity'];

    public function balls()
    {
        return $this->hasMany(Ball::class);
    }
}
