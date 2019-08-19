<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsersExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::select(['name', 'email', 'mobile', 'address'])->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email Adddress',
            'Mobile Number',
            'Addres',
        ];
    }
}
