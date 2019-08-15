<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;
use App\Quiz;
use App\Question;

class QuestionsImport implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueue, WithValidation
{
    private $quiz_id;

    public function __construct($quiz)
    {
        $this->quiz_id = $quiz;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        /**
         * Stop import on last row,
         * package has bug where it still tries to import the last row
         */
        if(is_null($row)){
            return;
        }

        $question = new Question([
            'question' => $row['question'],
            'a' => $row['a'],
            'b' => $row['b'],
            'c' => $row['c'],
            'd' => $row['d'],
            'answer' => $row['answer'],
            'answer_explanation' => $row['answer_explanation'] ?? NULL,
        ]);

        $quiz = Quiz::findOrFail($this->quiz_id);
        $quiz->questions()->save($question);

        return;
    }

    /**
     * Chunk importing size
     */
    public function chunkSize(): int
    {
        return 500;
    }

    /**
     * Import validations
     */
    public function rules(): array
    {
        return [
            'question' => 'required|max:255',
            'a' => 'required|max:255',
            'b' => 'required|max:255',
            'c' => 'required|max:255',
            'd' => 'required|max:255',
            'answer' => ['required', Rule::in(['a', 'b', 'c', 'd'])],
        ];
    }

    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return [
            'question' => 'Question',
            'a' => 'Choice A',
            'b' => 'Choice B',
            'c' => 'Choice C',
            'd' => 'Choice D',
            'answer' => 'Answer',
            'answer_explanation' => 'Answer Explanation'
        ];
    }
}
