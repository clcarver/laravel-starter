<?php

namespace App\Imports;

use App\Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExceptionImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue, WithEvents
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
        return new Exception([
            'user_id' => $row['employeeid'],
            'activity_code' => $row['activity_code'],
            'activity_name' => $row['activity_name'],
            'activity_type' => $row['activity_type'],
            'assignment_type' => $row['assignment_type'],
            'assignment_status' => $row['assignment_status'],
            'is_satisfied' => $row['satisfied_status'] == 'Yes' ? 1 : 0,
            'requirement_status' => $row['requirement_status'],
            'assigned_on' => Date::excelToDateTimeObject($row['assigned_on'])->format('Y-m-d H:i:s'),
            'due_on' => $row['due_date'] == '' ? null : Date::excelToDateTimeObject($row['due_date'])->format('Y-m-d'),
            'completed_on' => $row['end_date'] == '' ? null : Date::excelToDateTimeObject($row['end_date'])->format('Y-m-d H:i:s'),
            'expires_in' => $row['expiration_date_days_left'] == '' ? null : $row['expiration_date_days_left'],
            'is_certification' => $row['is_certification'],
            'is_active' => $row['active']
        ]);
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 2000;
    }

    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 2000;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [];
    }
}
