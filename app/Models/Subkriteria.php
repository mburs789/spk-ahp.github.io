<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subkriteria extends Model
{
    use HasFactory;

    protected $table = 'subkriterias';
    protected $fillable = ['kriteria_id', 'kode_subkriteria', 'nama_subkriteria', 'nilai_min', 'nilai_max', 'eigen_vector'];

    public function kriteria(){
        return $this->belongsTo(Kriteria::class);
    }
}

