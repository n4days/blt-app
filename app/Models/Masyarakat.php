<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masyarakat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nik',
        'nama_lengkap',
        'alamat',
        'desa',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'pekerjaan',
        'penghasilan',
        'jumlah_tanggungan',
        'status_rumah',
        'status_ekonomi',
        'tanggal_penyaluran',
        'nominal_bantuan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
