<?php

namespace Controllers\Products;

use Controllers\PublicController;
use Dao\Products\Products;
use Views\Renderer;

class ProductsList extends PublicController
{
    public function run(): void
    {
        $productsDao = Products::obtenerProducts();

        foreach ($productsDao as &$productos) {
            $productos['estado_dsc'] = [
                "DIS" => "Disponible",
                "INA" => "Inactivo",
                "AGO" => "Agotado"
            ][$productos['productStatus']] ?? "Desconocido";
        }

        $viewData = [
            "productos" => $productsDao
        ];
        
        Renderer::render('products/products', $viewData);

    }
}

