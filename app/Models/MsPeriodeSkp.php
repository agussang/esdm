<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class MsPeriodeSkp extends Model
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'neoskp.ms_periode';
    protected $primaryKey = 'id';
    public $keyType = 'string';
    
    protected $guarded = [];
}
