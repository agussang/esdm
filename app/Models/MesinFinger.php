<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MesinFinger extends Model
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'ms_mesin_finger';
    protected $primaryKey = 'id_mesin';
    public $keyType = 'string';
    protected $guarded = [];
}
