<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class MsPegawaiNew extends Model
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'ms_pegawai_new';
    protected $primaryKey = 'id_sdm';
    public $keyType = 'string';
    
    protected $guarded = [];
}
