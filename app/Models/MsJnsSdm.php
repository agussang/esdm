<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MsJnsSdm extends Model
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'ms_jns_sdm';
    protected $primaryKey = 'id_jns_sdm';
    public $keyType = 'string';
    protected $guarded = [];
}
