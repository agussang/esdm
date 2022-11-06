<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrPrilakuPegawai extends Model
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'neoskp.tr_perilaku_pegawai';
    protected $primaryKey = 'id';
    public $keyType = 'string';
    
    protected $guarded = [];

    public function dt_periode()
    {
        return $this->belongsTo(MsPeriodeSkp::class, 'idperiode', 'id');
    }

    public function dt_prilaku()
    {
        return $this->belongsTo(MsPrilaku::class, 'id_perilaku', 'id');
    }
}
