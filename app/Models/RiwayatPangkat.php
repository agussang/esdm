<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;

class RiwayatPangkat extends Model
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'riwayat_pangkat';
    protected $primaryKey = 'id_rwyt_pangkat';
    public $keyType = 'string';
    
    protected $guarded = [];

    public function dt_pegawai()
    {
        return $this->belongsTo(MsPegawai::class, 'id_sdm', 'id_sdm');
    }
    public function nm_eselon()
    {
        return $this->belongsTo(MsEselon::class, 'id_eselon', 'id');
    }
}
