<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FileImport implements ToCollection,WithCalculatedFormulas,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
    	$FileContent=array();

        foreach ($rows as $key => $row) 
        {  
          	$Content = ([
                'Date'=> $row['date'],
                'Timings' => $row['timings'],
                'ID' => $row['id'],
                'UserID' => $row['userid'],
                'Name' => $row['name'],
                'Details' => $row['details'],
                'Floor' => $row['floor'],
                'Branch' => $row['branch'],
            ]);        		
        	array_push($FileContent, $Content);      
        }    
             
        Storage::disk('Uploads')->put('1'.'.json',json_encode($FileContent));

        return 1;
    }

    public function headingRow(): int
    {
        return 1;
    }   
}
