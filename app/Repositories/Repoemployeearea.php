<?php
namespace App\Repositories;

use App\Models\PersonnelEmployeeArea;
use Illuminate\Support\Facades\DB;

class Repoemployeearea extends Repository
{
    protected $model;

    public function __construct(PersonnelEmployeeArea $model)
    {
        $this->model = $model;
    }
}
