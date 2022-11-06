<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsGolongan extends Model
{
    public $incrementing = false;
    protected $table = 'ms_golongan';
    protected $primaryKey = 'id';
    public $keyType = 'string';
}
