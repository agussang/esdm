<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrRekapSkp extends Model
{

    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'neoskp.tr_rekap_skp';
    protected $primaryKey = 'id';
    public $keyType = 'string';
    
    protected $guarded = [];

    public function dt_pegawai()
    {
        return $this->belongsTo(MsPegawai::class, 'id_sdm', 'id_sdm');
    }

    public function dt_periode()
    {
        return $this->belongsTo(MsPeriodeSkp::class, 'idperiode', 'id');
    }
}
