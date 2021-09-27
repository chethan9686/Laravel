<?php

namespace App\Imports;

use App\MumbaiPunchIn;
use Maatwebsite\Excel\Concerns\ToModel;

class MumbaiAttendenceImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (!empty($row))
        {
            return new MumbaiPunchIn([           
                'emp_id' => $row[3],
                'card_id' => $row[2],
                'emp_name' => $row[4],
                'date' => $row[0],
                'time' => $row[1],
                'punch_details' => $row[5],
                'gate' => $row[6],
                'location' => $row[7]
            ]);
        }         
    }
}
