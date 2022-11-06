<?php

namespace App\Models;


use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MsGrade extends Model
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'ms_grade';
    protected $primaryKey = 'id';
    public $keyType = 'string';

    protected $guarded = [];
}
