<?php

namespace App\Exports;

use App\Question;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class QuestionsExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    private $quiz_id;

    public function __construct($quiz)
    {
        $this->quiz_id = $quiz;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Question::where('quiz_id', $this->quiz_id)
                        ->select(['question', 'a', 'b', 'c', 'd', 'answer', 'answer_explanation'])->get();
    }

    public function headings(): array
    {
        return [
            'Question',
            'Choice A',
            'Choice B',
            'Choice C',
            'Choice D',
            'Answer',
            'Answer Explanation',
        ];
    }

}
