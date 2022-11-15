<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MsStatusAktif extends Model
{
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'ms_statusaktif';
    protected $primaryKey = 'id';
    public $keyType = 'string';

    protected $guarded = [];
}
