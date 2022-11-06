<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrJustifikasi extends Model
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'tr_justifikasi';
    protected $primaryKey = 'id_justifikasi';
    public $keyType = 'string'; 
    protected $guarded = [];
}