<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrAbsenKehadiran extends Model
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'tr_absen_kehadiran';
    protected $primaryKey = 'id_absen';
    public $keyType = 'string';
    protected $guarded = [];

    public function dt_pegawai()
    {
        return $this->belongsTo(MsPegawai::class, 'id_sdm', 'id_sdm');
    }

    public function r_alasan()
    {
        return $this->belongsTo(MsAlasanAbsen::class, 'id_alasan', 'id_alasan');
    }
}
