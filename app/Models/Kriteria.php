<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subkriteria;


class Kriteria extends Model
{
    use HasFactory;

    protected $fillable = ['kode_kriteria', 'nama_kriteria', 'eigen_vector'];


    public function subkriterias()
    {
        return $this->hasMany(Subkriteria::class, 'kriteria_id');
    }

}
