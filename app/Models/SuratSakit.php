<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratSakit extends Model
{
    protected $table = 'suratsakit';
    protected $primaryKey = 'no_surat'; // set primary key yang benar
    public $incrementing = false; // jika bukan auto-increment
    protected $keyType = 'string';
}
