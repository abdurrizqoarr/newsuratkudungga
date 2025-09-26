<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignDokumen extends Model
{
    use HasUuids;

    protected $table = 'sign_dokumen';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'file',
        'nik',
        'nama_file',
        'no_rawat',
    ];
}
