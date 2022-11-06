<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsPendidikan extends Model
{
    public $incrementing = false;
    protected $table = 'ms_pendidikan';
    protected $primaryKey = 'id';
    public $keyType = 'string';
}
