<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class matakuliah extends Model
{
    use HasFactory;
    protected $fillable = [
        'nm_jurusan',
        'nm_mk',
        'kd_mk',
        'kd_jur',
        'kd_kur',
        'semester',
        'sks',
        'nm_intl',
    ];
    public function nilais()
    {
        return $this->hasMany(nilai::class);
    }

    public function jadwalmatakuliahs()
    {
        return $this->hasMany(jadwalmatakuliah::class);
    }
}
