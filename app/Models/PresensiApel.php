<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class PresensiApel extends Model
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'presensi_apel';
    protected $primaryKey = 'id_presensi';
    public $keyType = 'string';
    
    protected $guarded = [];

    public function dt_pegawai()
    {
        return $this->belongsTo(MsPegawai::class, 'id_sdm', 'id_sdm');
    }

    public function nm_kegiatan_apel(){
        return $this->belongsTo(MsKegiatanApel::class, 'id_kegiatan', 'id_kegiatan');
    }
}
