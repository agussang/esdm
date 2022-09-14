<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class MsPegawai extends Model
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'ms_pegawai';
    protected $primaryKey = 'id_sdm';
    public $keyType = 'string';
    
    protected $guarded = [];
    public function nm_atasan(){
        return $this->belongsTo(MsPegawai::class, 'id_sdm_atasan', 'id_sdm');
    }
    public function nm_atasan_pendamping(){
        return $this->belongsTo(MsPegawai::class, 'id_sdm_pendamping', 'id_sdm');
    }
    public function nm_jns_sdm()
    {
        return $this->belongsTo(MsJnsSdm::class, 'id_jns_sdm', 'id_jns_sdm');
    }

    public function nm_kedinasan(){
        return $this->belongsTo(MsKedinasan::class, 'id_kedinasan', 'id_kedinasan');
    }

    public function nm_satker()
    {
        return $this->belongsTo(SatuanUnitKerja::class, 'id_satkernow', 'id_sms');
    }

    public function stat_kepegawaian()
    {
        return $this->belongsTo(MsStatusKepegawaian::class, 'id_stat_kepegawaian', 'id');
    }

    public function nm_golongan()
    {
        return $this->belongsTo(MsGolongan::class, 'id_golongannow', 'id_golongan');
    }

    public function nm_jab_fung()
    {
        return $this->belongsTo(MsJabatan::class, 'id_jabatan_fungsional_now', 'id');
    }

    public function nm_jab_struk()
    {
        return $this->belongsTo(MsJabatan::class, 'id_jabatan_struktural_now', 'id');
    }

    public function stat_aktif()
    {
        return $this->belongsTo(MsStatusAktif::class, 'id_stat_aktif', 'id');
    }

    public function nm_agama()
    {
        return $this->belongsTo(MsAgama::class, 'id_agama', 'id');
    }

    public function nm_pendidikan()
    {
        return $this->belongsTo(MsPendidikan::class, 'id_pendidikan_terakhir', 'id');
    }
}
