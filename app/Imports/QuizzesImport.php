<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Quiz;

class QuizzesImport implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueue, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        /**
         * this is for possible excel column names for each table column
         * but unfortunately, this doesn't work because of the rules function
         */
        // return new Quiz([
        //     'title' => $row['title'] ?? $row['quiz_title'] ?? null,
        //     'description' => $row['description'] ?? $row['quiz_description'] ?? null,
        //     'points_per_question' => $row['points_per_question'] ?? $row['points'] ?? $row['points_each'] ?? null,
        //     'timer' => $row['timer'] ?? $row['quiz_timer'] ?? $row['total_timer'] ?? null,
        // ]);

        /**
         * Stop import on last row, 
         * package has bug where it still tries to import the last row
         */
        if(is_null($row)){
            return;
        }


        return new Quiz([
            'title' => $row['title'],
            'description' => $row['description'] ?: NULL,
            'points_per_question' => $row['points_per_question'],
            'timer' => $row['timer'],
        ]);
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
            'title' => 'required|max:255',
            'points_per_question' => 'required|numeric|min:1',
            'timer' => 'required|numeric|min:1'
        ];
    }

    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return [
            'title' => 'Title',
            'points_per_question' => 'Points Per Question',
            'timer' => 'Timer'
        ];
    }
}
