<?php

namespace App\Imports;

use App\Catalog;
use App\Services\Encode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CatalogImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue, WithEvents
{
    use Queueable;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     * @throws \Exception
     */
    public function model(array $row)
    {
        return new Catalog([
            'id' => $row['id'],
            'parent_id' => $row['parent_id'],
            'reference_id' => $row['reference_id'],
            'activity_code' => $row['activity_code'],
            'activity_name' => Encode::fixUTF8($row['activity_name']),
            'activity_type' => $row['activity_type'],
            'estimated_duration' => $row['estimated_duration'] == '' ? null : $row['estimated_duration']
        ]);
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 2500;
    }

    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 2500;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [];
    }
}
