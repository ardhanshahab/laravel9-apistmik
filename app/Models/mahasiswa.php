<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mahasiswa extends Model
{
    use HasFactory;
    protected $fillable = [
        'nim',
        'nm_mhs',
        'jurusan',
        'kelas',
        'masuk_tahun',
        'jk',
        'ttl',
        'gol_darah',
        'nmr_hp',
        'email',
    ];
    public function nilais()
    {
        return $this->hasMany(nilai::class);
    }
}
