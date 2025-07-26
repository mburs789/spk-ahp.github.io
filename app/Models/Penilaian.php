<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $fillable = ['karyawan_id', 'kriteria_id', 'subkriteria_id', 'nilai'];

     // Relasi ke Karyawan
     public function karyawan()
     {
         return $this->belongsTo(Karyawan::class, 'karyawan_id');
     }
 
     // Relasi ke Kriteria
     public function kriteria()
     {
         return $this->belongsTo(Kriteria::class, 'kriteria_id');
     }
 
     // Relasi ke Subkriteria
     public function subkriteria()
     {
         return $this->belongsTo(Subkriteria::class, 'subkriteria_id');
     }
}
