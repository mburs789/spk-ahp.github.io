<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perangkingan extends Model
{
    use HasFactory;

    protected $fillable = ['karyawan_id', 'ranking', 'status'];

    // Relasi dengan Karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
