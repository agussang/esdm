<?php
namespace App\Repositories;

use App\Models\TrSettingApp;
use Illuminate\Support\Facades\DB;

class Reposettingapp extends Repository
{
    protected $model;

    public function __construct(TrSettingApp $model)
    {
        $this->model = $model;
    }

}