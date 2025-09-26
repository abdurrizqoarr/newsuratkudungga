<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumePasienRalan extends Model
{
    protected $table = 'resume_pasien';
    protected $primaryKey = 'no_rawat'; // set primary key yang benar
    public $incrementing = false; // jika bukan auto-increment
    protected $keyType = 'string';
}
