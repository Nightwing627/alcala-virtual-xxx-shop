<?php

namespace App\Exports;

use App\Newsletter;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NewsletterExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Newsletter::select('id', 'email', 'created_at')->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'email',
            'fecha',
        ];
    }
}
