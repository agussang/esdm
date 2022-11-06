<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SatuanUnitKerja extends Model
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'ms_satker';
    protected $primaryKey = 'id_sms';
    public $keyType = 'string'; 
    protected $guarded = [];
}
