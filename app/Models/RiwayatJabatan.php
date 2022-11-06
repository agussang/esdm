<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatJabatan extends Model
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'riwayat_jabatan';
    protected $primaryKey = 'id_rwyt_jabatan';
    public $keyType = 'string';
    
    protected $guarded = [];

    public function dt_pegawai()
    {
        return $this->belongsTo(MsPegawai::class, 'id_sdm', 'id_sdm');
    }
    public function nm_jabatan()
    {
        return $this->belongsTo(MsJabatan::class, 'id_jabatan', 'id_jabatan');
    }
}
