<?php
namespace App\Repositories;

use App\Models\PersonnelEmployee;
use Illuminate\Support\Facades\DB;

class Repoemployee extends Repository
{
    protected $model;

    public function __construct(PersonnelEmployee $model)
    {
        $this->model = $model;
    }

}
