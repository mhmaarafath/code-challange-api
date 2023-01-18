<?php

namespace App\Imports;

use App\Models\Attendance;
use App\Models\Worker;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AttendanceImport implements ToCollection, SkipsEmptyRows, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Attendance::create([
                'employee_id' => $row['employee_id'],
                'checkin' => $row['checkin'],
                'checkout' => $row['checkout'],
            ]);
        }
    }

}
