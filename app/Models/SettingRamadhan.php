<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class SettingRamadhan extends Model
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'setting_ramadhan';
    protected $primaryKey = 'id_setting';
    public $keyType = 'string';

    protected $guarded = [];
}
