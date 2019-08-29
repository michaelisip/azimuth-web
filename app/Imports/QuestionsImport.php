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
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class QuestionsImport implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueue, WithValidation, SkipsOnFailure, WithBatchInserts
{
    use Importable, SkipsFailures;

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
        return 200;
    }

    /**
     * Insert questions by batch
     */
    public function batchSize(): int
    {
        return 500;
    }

    /**
     * Import validations
     */
    public function rules(): array
    {
        return [
            'question' => 'required|unique:questions',
            'a' => 'required',
            'b' => 'required',
            'c' => 'required',
            'd' => 'required',
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
