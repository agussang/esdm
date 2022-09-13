<?php
namespace App\Repositories;

use App\Models\MsRubrik;
use Illuminate\Support\Facades\DB;

class Repomsrubrik extends Repository
{
    protected $model;

    public function __construct(MsRubrik $model)
    {
        $this->model = $model;
    }

    public function get($with = null,$id_level = 1,$id_induk = null)
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })->when($id_level, function ($query) use ($id_level) {
                return $query->where("level",$id_level);
            })->when($id_induk, function ($query) use ($id_induk) {
                return $query->where("idparent",$id_induk);
            })
            //->whereRaw("(idparent = '02e612b3-8530-4fde-b0a9-92632e572aa5' or id = '02e612b3-8530-4fde-b0a9-92632e572aa5')")
            ->orderBy('urutan','asc')
            ->get();
    }
}