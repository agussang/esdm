<?php

namespace App\Models;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrLogLogin extends Model
{
    use SoftDeletes;
    use Uuid;
    public $incrementing = false;
    protected $table = 'tr_log_login';
    protected $primaryKey = 'id_log';
    public $keyType = 'string';

    protected $guarded = [];
}
