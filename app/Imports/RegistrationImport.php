<?php

namespace App\Imports;

use App\CompletedActivities;
use App\Registration;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class RegistrationImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue, WithEvents
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
        return new Registration([
            'activity_code' => $row['activity_code'],
            'delivery_method' => $row['delivery_method'],
            'location' => $row['location_name'],
            'participant_count' => $row['participant_count'],
            'course_name' => $row['course_name'],
            'user_id' => $row['employee_id'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'registration_date' => Date::excelToDateTimeObject($row['registration_date'])->format('Y-m-d'),
            'manager_id' => $row['managers_employee_number'],
            'manager' => $row['manager_full_name'],
            'start_date' => Date::excelToDateTimeObject($row['start_date'])->format('Y-m-d H:i:s'),
            'end_date' => Date::excelToDateTimeObject($row['end_date'])->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 50;
    }

    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 50;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [];
    }
}
