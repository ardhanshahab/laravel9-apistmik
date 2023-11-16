<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jadwalmatakuliah extends Model
{
    use HasFactory;
    protected $fillable = [
        'kd_mk',
        'hari',
        'masuk',
        'selesai',
        'nama_dosen',
        'kelas',
        'ruangan',
    ];
    public function matakuliah()
{
    return $this->belongsTo(Matakuliah::class, 'kd_mk', 'kd_mk');
}

}
