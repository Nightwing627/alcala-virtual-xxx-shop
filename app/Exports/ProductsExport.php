<?php

namespace App\Exports;

use App\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::select('sku', 'name', 'description', 'price', 'stock', 'tags')->get();
    }

    public function headings(): array
    {
        return [
            'sku',
            'nombre',
            'descripcion',
            'precio',
            'cantidad',
            'tags'
        ];
    }
}
