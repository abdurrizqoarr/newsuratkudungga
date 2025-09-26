<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonsultasiMedik extends Model
{
    protected $table = 'konsultasi_medik';
    protected $primaryKey = 'no_permintaan'; // set primary key yang benar
    public $incrementing = false; // jika bukan auto-increment
    protected $keyType = 'string';
}
