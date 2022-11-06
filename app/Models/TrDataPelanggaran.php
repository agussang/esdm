<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrDataPelanggaran extends Model
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'tr_data_pelanggaran';
    protected $primaryKey = 'id_pelanggaran';
    public $keyType = 'string'; 
    protected $guarded = [];

    public function dt_pegawai()
    {
        return $this->belongsTo(MsPegawai::class, 'id_sdm', 'id_sdm');
    }

    public function kategori_pelanggaran()
    {
        return $this->belongsTo(MsKategoriPelanggaran::class, 'id_kategori_pelanggaran', 'id_pelanggaran');
    }
}