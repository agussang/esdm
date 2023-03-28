<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrJadwalShift extends Model
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'tr_jadwal_shift_pegawai';
    protected $primaryKey = 'id_jadwal_shift';
    public $keyType = 'string';

    protected $guarded = [];

    public function dt_pegawai()
    {
        return $this->belongsTo(MsPegawai::class, 'id_sdm', 'id_sdm');
    }

    public function dtwaktuabsen()
    {
        return $this->belongsTo(MsWaktuShift::class, 'id_shift', 'id');
    }
}
