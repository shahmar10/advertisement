<?php

namespace App\Imports;

use App\Models\Car;
use App\Models\CarModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CarModelImport implements ToCollection
{
    private string $createdBy;

    public function __construct(int $createdBy)
    {
        $this->createdBy = $createdBy;
    }

    public function collection(Collection $rows)
    {
        $i = 0;

        foreach ($rows as $row)
        {
            if ($i++ == 0 || !($row[0] ?? null))
                continue;

            CarModel::query()
                ->create([
                    'name' => $row[0],
                    'car_id' => $row[1],
                    'created_by' => $this->createdBy,
                ]);
        }

        $rows = [
            [
                'name',
                'car_id'
            ],
            [
                'Astra',
                '108'
            ],
            [
                'Vectra',
                '108'
            ],
            [
                'corsa',
                '108'
            ]
        ];



    }
}
