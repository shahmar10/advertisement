<?php

namespace App\Imports;

use App\Models\Car;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CarImport implements ToCollection
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

            $check = Car::query()
                ->where('name', $row[0])
                ->exists();

            if ($check)
                continue;

            Car::query()
                ->create([
                    'name' => $row[0],
                    'created_by' => $this->createdBy
                ]);
        }
    }
}
