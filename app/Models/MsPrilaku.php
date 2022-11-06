<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class MsPrilaku extends Model
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'neoskp.ms_perilaku';
    protected $primaryKey = 'id';
    public $keyType = 'string';
    
    protected $guarded = [];
}
