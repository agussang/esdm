<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MsAlasanAbsen extends Model
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'ms_alasan_absen';
    protected $primaryKey = 'id_alasan';
    public $keyType = 'string';

    protected $guarded = [];
}
