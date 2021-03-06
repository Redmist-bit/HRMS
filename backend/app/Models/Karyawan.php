<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected $table = 'karyawan';
    protected $primaryKey = 'Kode_Karyawan';
    const CREATED_AT = 'DiBuatTgl';
    const UPDATED_AT = 'DiubahTgl';
    public function anak()
    {
        return $this->hasMany(Child::class,'KodeKaryawan','KODE_KARYAWAN');
    }
}
