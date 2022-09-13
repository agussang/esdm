<?php
namespace App\Repositories;

use App\Models\MsPeriodeSkp;
use Illuminate\Support\Facades\DB;

class Repomsperiodeskp extends Repository
{
    protected $model;

    public function __construct(MsPeriodeSkp $model)
    {
        $this->model = $model;
    }

    public function get($with = null,$tahun = null)
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })
            ->when($tahun, function ($query) use ($tahun) {
                return $query->where('tahun',$tahun);
            })
            ->orderBy('bulan','asc')
            ->get();
    }
}