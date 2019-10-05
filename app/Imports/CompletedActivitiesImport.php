<?php

namespace App\Imports;

use App\CompletedActivities;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CompletedActivitiesImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue, WithEvents
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
        preg_match('/(Shift)/', $row['user_secondary_org1'], $shift1);
        preg_match('/(Shift)/', $row['user_secondary_org2'], $shift2);
        preg_match('/(Shift)/', $row['user_secondary_org3'], $shift3);

        if(sizeof($shift1) > 1)
            $shift = $row['user_secondary_org1'];
        elseif(sizeof($shift2) > 1)
            $shift = $row['user_secondary_org2'];
        else
            $shift = $row['user_secondary_org3'];

        return new CompletedActivities([
            'user_id' => $row['user_number'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'email' => $row['email'],
            'activity_name' => $row['activity_name'],
            'activity_code' => $row['activity_code'],
            'activity_label' => $row['activity_label'],
            'completion_date' => Date::excelToDateTimeObject($row['completion_date'])->format('Y-m-d'),
            'manager_id' => $row['managers_employee_number'],
            'manager_first_name' => $row['manager_first_name'],
            'manager_last_name' => $row['manager_last_name'],
            'manager_email' => $row['manager_email'],
            'user_primary_job' => $row['user_primary_job'],
            'organization' => $row['user_primary_organization'],
            'expires' => $row['activity_expiration_date'] == '' ? null : Date::excelToDateTimeObject($row['activity_expiration_date'])->format('Y-m-d'),
            'shift' => $this->shift($shift),
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

    public function shift($shit)
    {
        switch ($shit) {
            case "Shift A":
                return 'A';
            case "Shift B":
                return 'B';
            case "Shift C":
                return 'C';
            case "Shift D":
                return 'D';
            case "Shift E":
                return 'E';
            default:
                return '?';
        }
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [];
    }
}
