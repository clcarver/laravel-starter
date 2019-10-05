<?php


namespace App\Imports;


use App\LmsUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class LmsUserImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue, WithEvents
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

        return new LmsUser([
            'id' => $row['user_number'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'account' => $row['user_name'],
            'lms_role' => $row['user_primary_security_role'],
            'domain' => $row['user_primary_domain'],
            'organization' => $row['organization'],
            'code' => $row['code'],
            'position' => $row['position'],
            'email' => $row['email'],
            'manager_id' => $row['managers_employee_number'],
            'manager_first_name' => $row['manager_first_name'],
            'manager_last_name' => $row['manager_last_name'],
            'manager_email' => $row['manager_email'],
            'start_date' => Date::excelToDateTimeObject($row['user_start_date'])->format('Y-m-d'),
            'shift' => $this->shift($shift)
        ]);
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 25;
    }

    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 25;
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

