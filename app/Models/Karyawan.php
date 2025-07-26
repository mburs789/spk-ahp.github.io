<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Karyawan extends Model
{
    use HasFactory;

    protected $fillable = ['nik', 'nama_karyawan', 'jabatan'];

    public function penilaians(): HasMany
    {
        return $this->hasMany(Penilaian::class, 'karyawan_id', 'id');
    }
}
