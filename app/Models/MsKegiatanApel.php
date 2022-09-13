<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class MsKegiatanApel extends Model
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'ms_kegiatan_apel';
    protected $primaryKey = 'id_kegiatan';
    public $keyType = 'string';
    
    protected $guarded = [];

    public function peserta()
    {
        return $this->hasMany(PresensiApel::class, 'id_kegiatan', 'id_kegiatan');
    }
}
