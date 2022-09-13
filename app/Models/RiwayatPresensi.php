<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class RiwayatPresensi extends Model
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'riwayat_finger';
    protected $primaryKey = 'id_finger';
    public $keyType = 'string';

    protected $guarded = [];
}
