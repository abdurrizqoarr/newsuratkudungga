<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferensiMobileJKNBPJS extends Model
{
    use HasFactory;

    protected $table = 'referensi_mobilejkn_bpjs';

    protected $primaryKey = 'nobooking';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'no_rawat',
        'nomorkartu',
        'nik',
        'nohp',
        'kodepoli',
        'pasienbaru',
        'norm',
        'tanggalperiksa',
        'kodedokter',
        'jampraktek',
        'jeniskunjungan',
        'nomorreferensi',
        'nomorantrean',
        'angkaantrean',
        'estimasidilayani',
        'sisakuotajkn',
        'sisakuotanonjkn',
        'kuotanonjkn',
        'status',
        'validasi',
        'statuskirim',
    ];

    public $timestamps = false;
}
