<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MsKedinasan extends Model
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'ms_kedinasan';
    protected $primaryKey = 'id_kedinasan';
    public $keyType = 'string';

    protected $guarded = [];
}
