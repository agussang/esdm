<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsJnsSdm extends Model
{
    public $incrementing = false;
    protected $table = 'ms_jns_sdm';
    protected $primaryKey = 'id_jns_sdm';
    public $keyType = 'string'; 
}
