<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kereta extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'kapasitas'];

    public function tikets()
    {
        return $this->hasMany(Tiket::class);
    }
}
