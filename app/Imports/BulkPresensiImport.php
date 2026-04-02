<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;

class BulkPresensiImport implements ToModel
{
    public function model(array $row)
    {
        // Hanya dipakai untuk Excel::toArray(), tidak perlu logic disini
    }
}
