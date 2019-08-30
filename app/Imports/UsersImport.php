<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class UsersImport implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueue, WithValidation, SkipsOnFailure, WithBatchInserts
{
    use Importable, SkipsFailures;

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
        // return new User([
        //     'name' => $row['name'] ?? $row['student_name'],
        //     'email' => $row['email'] ?? $row['email_address'],
        //     'password' => Hash::make('password'),
        //     'mobile' => $row['mobile'] ?? $row['number'] ?? $row['phone_number'] ?? $row['mobile_phone'] ?? $row['mobile_number'] ?? NULL,
        //     'address' => $row['address'] ?? $row['student_address'] ?? NULL,
        // ]);

        /**
         * Stop import on last row,
         * package has bug where it still tries to import the last row
         */
        if(is_null($row)){
            return;
        }

        return new User([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => 'password',
            'mobile' => $row['mobile'] ?? NULL,
            'address' => $row['address'] ?? NULL,
        ]);

    }

    /**
     * Chunk importing size
     */
    public function chunkSize(): int
    {
        return 250;
    }

    /**
     * Insert questions by batch
     */
    public function batchSize(): int
    {
        return 1000;
    }
    /**
     * Import validations
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'mobile' => ['nullable', 'regex:/^(09|\+639|9)\d{9}$/'],
            'address' => 'nullable'
        ];
    }


    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return [
            'name' => 'Full Name',
            'email' => 'Email Address',
            'mobile' => 'Mobile Number',
            'address' => 'Address'
        ];
    }
}
