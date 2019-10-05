<?php


namespace App\Imports;


use App\LmsUser;
use App\Registration;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class LmsUserImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue, WithEvents
{
    use \Illuminate\Bus\Queueable;

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

        return new LmsUser([
            'user_id' => $row['user_number'],
            'first_name' => $row['delivery_method'],
            'last_name' => $row['location_name'],
            'is_active' => $row['participant_count'],
            'account' => $row['course_name'],
            'lms_role' => $row['employee_id'],
            'domain' => $row['first_name'],
            'organization' => $row['last_name'],
            'code' => Date::excelToDateTimeObject($row['registration_date'])->format('Y-m-d'),
            'position' => $row['managers_employee_number'],
            'email' => $row['manager_full_name'],
            'manager_id' => Date::excelToDateTimeObject($row['start_date'])->format('Y-m-d H:i:s'),
            'manager_first_name' => Date::excelToDateTimeObject($row['end_date'])->format('Y-m-d H:i:s'),
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
}

