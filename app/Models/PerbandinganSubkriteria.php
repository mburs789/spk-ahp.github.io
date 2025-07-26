<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerbandinganSubkriteria extends Model
{
    use HasFactory;
    protected $table = 'perbandingan_subkriterias';
    // protected $fillable = ['kriteria_id', 'subkriteria_1_id', 'subkriteria_2_id', 'nilai'];
    protected $guarded = [];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }

    public function subkriteria1()
    {
        return $this->belongsTo(Subkriteria::class, 'subkriteria_1_id');
    }

    public function subkriteria2()
    {
        return $this->belongsTo(Subkriteria::class, 'subkriteria_2_id');
    }
}
