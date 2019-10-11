<?php

namespace App\Imports;

use App\Assignments;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AssignmentImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue, WithEvents
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
    }

    /**
     * @param array $row
     *
     * @return Model|Model[]|null
     * @throws \Exception
     */
    public function model(array $row)
    {
        return new Assignments([
            'user_id' => $row['user_number'],
            'activity_code' => $row['activity_code'],
            'activity_name' => $row['activity_name'],
            'activity_type' => $row['activity_label'],
            'requirement_status' => $row['requirement_status'],
            'satisfied' => $row['satisfied'],
            'completion_date' => $row['attempt_end_date'] != '' ? Date::excelToDateTimeObject($row['attempt_end_date'])->format('Y-m-d') : null,
            'due_date' => $row['due_date'] != '' ? Date::excelToDateTimeObject($row['due_date'])->format('Y-m-d') : null,
            'is_certification' => $row['is_certification'] == 'Yes' ? 1 : 0
        ]);
    }

    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 1000;
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [];
    }
}
