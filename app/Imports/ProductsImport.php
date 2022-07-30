<?php

namespace App\Imports;

use App\Product;
use App\Category;
use App\Subcategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        if( $producto = Product::where('sku', $row['sku'])->first() ){
            $producto->name = $row['nombre'];
            $producto->description = $row['descripcion'];
            $producto->price = $row['precio'] ? $row['precio'] : 0.00;
            $producto->stock = isset($row['stock']) ? $row['stock'] : 1;
            $producto->measure = isset($row['medida']) ? $row['medida'] : null;
            $producto->weight = isset($row['peso']) ? $row['peso'] : null;
            $producto->image_id = 2;

            //categoria
            if($row['categoria']){
                $categoria = Category::where('name', $row['categoria'])->first();
                if( !$categoria ){
                    $categoria = new Category();
                    $categoria->name = $row['categoria'];
                    $categoria->save();
                }
            }

            if($row['subcategoria']){
                $subcategoria = Subcategory::where('name', $row['subcategoria'])->first();
                if(!$subcategoria){
                    $subcategoria = new Subcategory();
                    $subcategoria->name = $row['subcategoria'];
                    $subcategoria->category_id = $categoria->id;
                    $subcategoria->save();
                }
            }

            $producto->category_id = $categoria ? $categoria->id : null;
            $producto->subcategory_id = $subcategoria ? $subcategoria->id : null;
            $producto->save();

            return $producto;

        }else{
            $producto = new Product();
            $producto->sku = $row['sku'];
            $producto->name = $row['nombre'];
            $producto->description = $row['descripcion'];
            $producto->price = $row['precio'] ? $row['precio'] : 0.00;
            $producto->stock = isset($row['stock']) ? $row['stock'] : 1;
            $producto->measure = isset($row['medida']) ? $row['medida'] : null;
            $producto->weight = isset($row['peso']) ? $row['peso'] : null;
            $producto->image_id = 2;

            //categoria
            if($row['categoria']){
                $categoria = Category::where('name', $row['categoria'])->first();
                if( !$categoria ){
                    $categoria = new Category();
                    $categoria->name = $row['categoria'];
                    $categoria->save();
                }
            }

            if($row['subcategoria']){
                $subcategoria = Subcategory::where('name', $row['subcategoria'])->first();
                if(!$subcategoria){
                    $subcategoria = new Subcategory();
                    $subcategoria->name = $row['subcategoria'];
                    $subcategoria->category_id = $categoria->id;
                    $subcategoria->save();
                }
            }

            $producto->category_id = $categoria ? $categoria->id : null;
            $producto->subcategory_id = $subcategoria ? $subcategoria->id : null;
            $producto->save();

            return $producto;
        }
    }
}
