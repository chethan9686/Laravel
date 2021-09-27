<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DownloadMumbai implements FromCollection, WithHeadings
{
    /**
    * @param Collection $collection
    */
    private $your_collection,$headings;

    public function __construct($data,$heading) {
        $this->your_collection = $data;
        $this->headings = $heading;
    }

    public function collection()
    {
        return $this->your_collection;
    }

    public function headings(): array
    {
        return [            
            $this->headings
        ];
    }
}
