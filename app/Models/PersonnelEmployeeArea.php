<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonnelEmployeeArea extends Model
{
    protected $connection = 'pgsqlfinger';
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'personnel_employee_area';
    protected $primaryKey = 'id';
    public $keyType = 'string';
    protected $guarded = [];
}
