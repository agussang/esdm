<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MsJabatan extends Model
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'ms_jabatan';
    protected $primaryKey = 'id';
    public $keyType = 'string';

    protected $guarded = [];

    public function ms_grade()
    {
        return $this->belongsTo(MsGrade::class, 'id_grade', 'id');
    }
}
