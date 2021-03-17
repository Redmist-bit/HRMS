<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;
    const CREATED_AT = 'DiBuatTgl';
    const UPDATED_AT = 'DiubahTgl';
    protected $fillable = ['KodeKaryawan','NamaAnak','AnakKe','DibuatOleh','DibuatTgl','DiubahOleh','DiubahTgl'];
    protected $table = 'anakkaryawan';
}
