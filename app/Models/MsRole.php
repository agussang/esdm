<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsRole extends Model
{
    public $incrementing = false;
    protected $table = 'ms_role_user';
    protected $primaryKey = 'id_role';
    public $keyType = 'string';    
}
