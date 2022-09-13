<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatPendidikan extends Model
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'riwayat_jabatan';
    protected $primaryKey = 'id_rwyt_jabatan';
    public $keyType = 'string';
    
    protected $guarded = [];
}
