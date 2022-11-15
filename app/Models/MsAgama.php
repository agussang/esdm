<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsAgama extends Model
{
    public $incrementing = false;
    protected $table = 'ms_agama';
    protected $primaryKey = 'id';
    public $keyType = 'string';

    protected $guarded = [];

}
