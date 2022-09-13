<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsAlasanAbsen extends Model
{
    public $incrementing = false;
    protected $table = 'ms_alasan_absen';
    protected $primaryKey = 'id_alasan';
    public $keyType = 'string';
}
