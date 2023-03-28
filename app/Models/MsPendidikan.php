<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsPendidikan extends Model
{
    use Uuid;
    public $incrementing = false;
    protected $table = 'ms_pendidikan';
    protected $primaryKey = 'id';
    public $keyType = 'string';
    protected $guarded = [];
}
