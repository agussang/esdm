<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsStatusKepegawaian extends Model
{
    public $incrementing = false;
    protected $table = 'ms_statuskepeg';
    protected $primaryKey = 'id';
    public $keyType = 'string'; 
}
