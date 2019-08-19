<?php

namespace App\Exports;

use App\Quiz;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class QuizzesExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Quiz::select(['title', 'description', 'points_per_question', 'timer'])->get();
    }

    public function headings(): array
    {
        return [
            'Title',
            'Description',
            'Points Per Question',
            'Timer',
        ];
    }

}
