<?php

namespace Controllers\Funciones;

use Controllers\PublicController;
use Dao\Funciones\Funciones;
use Views\Renderer;

class FuncionesList extends PublicController
{
    public function run(): void
    {
        $funcionesDao = Funciones::obtenerFunciones();

        foreach ($funcionesDao as &$funciones) {
            $funciones['estado_dsc'] = [
                "ACT" => "Activo",
                "INA" => "Inactivo",
                "SUS" => "Suspendido"
            ][$funciones['fnest']] ?? "Desconocido";
        }
        $viewData = [
            "funciones" => $funcionesDao,
        ];
        Renderer::render('funciones/funciones', $viewData);
    }
}
