<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsEselon extends Model
{
    public $incrementing = false;
    protected $table = 'ms_eselon';
    protected $primaryKey = 'id';
    public $keyType = 'string';

    protected $guarded = [];
}
