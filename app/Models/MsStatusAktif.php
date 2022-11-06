<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsStatusAktif extends Model
{
    public $incrementing = false;
    protected $table = 'ms_statusaktif';
    protected $primaryKey = 'id';
    public $keyType = 'string';   
}
