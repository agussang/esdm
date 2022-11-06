<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrStatusKepegawaian extends Model
{
    public $incrementing = false;
    protected $table = 'tr_status_kepegawaian';
    protected $primaryKey = 'id_status';
    public $keyType = 'string'; 

    public function nm_jns_sdm()
    {
        return $this->hasMany(MsJnsSdm::class, 'id_jns_sdm', 'id_jns_sdm');
    }

    public function nm_status()
    {
        return $this->hasMany(MsStatusKepegawaian::class, 'id', 'id_status_kepegawaian');
    }
}
