<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Hash;

class UsersImport implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueue, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'name' => $row['name'] ?? $row['student_name'],
            'email' => $row['email'] ?? $row['email_address'],
            'password' => Hash::make('password'),
            'mobile' => $row['mobile'] ?? $row['number'] ?? $row['phone_number'] ?? $row['mobile_phone'] ?? $row['mobile_number'] ?? NULL,
            'address' => $row['address'] ?? $row['student_address'] ?? NULL,
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile' => ['nullable', 'regex:/^(09|\+639|9)\d{9}$/'],
            'address' => 'nullable|max:255'
        ];
    }
}
