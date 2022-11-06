<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class MsRubrik extends Model
{
    use Uuid;
    use SoftDeletes;
    public $incrementing = false;
    protected $table = 'neoskp.ms_rubrik';
    protected $primaryKey = 'id';
    public $keyType = 'string';
    
    protected $guarded = [];

    public function nm_satuan()
    {
        return $this->belongsTo(MsSatuan::class, 'idsatuan', 'id');
    }
}
