<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;
    protected $fillable = ['kereta_id', 'stok'];

    public function kereta()
    {
        return $this->belongsTo(Kereta::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'pesanans')
                    ->withPivot('jumlah')
                    ->withTimestamps();
    }
}
