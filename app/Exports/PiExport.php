<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PiExport implements FromQuery, WithHeadings, WithMapping
{
    protected $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Phone',
            'Designation',
            'Department',
            'Status'
        ];
    }

    public function map($pi): array
    {
        return [
            $pi->id,
            $pi->getFullNameAttribute(),
            $pi->email,
            $pi->phone,
            $pi->designation,
            $pi->department,
            $pi->status == 1 ? 'Active' : 'Inactive'
        ];
    }
}
