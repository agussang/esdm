<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BindsDynamically;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'user';
    protected $primaryKey = 'id_user';
    public $keyType = 'string';
    protected $guarded = [];
    
    public function roleuser()
    {
        return $this->belongsTo(MsRole::class, 'id_role', 'id_role');
    }
}
