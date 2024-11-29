<?php

namespace Controllers\Citas;

use Controllers\PrivateController;
use Dao\Citas\Citas;
use Views\Renderer;

class CitasList extends PrivateController
{
    public function run(): void
    {
        $usercod = $_GET['usercod'] ?? '';
        if (!empty($usercod)) {
            $citasDao = Citas::obtenerCitasPorUsuario($usercod);
        } else {
            $citasDao = Citas::obtenerCitas();
        }

        foreach ($citasDao as &$cita) {
            $cita['EstadoCita'] = [
                "Pendiente" => "Pendiente",
                "Confirmada" => "Confirmada",
                "Cancelada" => "Cancelada",
                "Realizada" => "Realizada"
            ][$cita['EstadoCita']] ?? "Desconocido";
        }
        $viewData = [
            "citas" => $citasDao,
            "INS_enable" => $this->isFeatureAutorized('citas_INS_enabled'),
            "UPD_enable" => $this->isFeatureAutorized('citas_UPD_enabled'),
            "DEL_enable" => $this->isFeatureAutorized('citas_DEL_enabled'),
            "FechaCreacion_enable" => $this->isFeatureAutorized('citas_FechaCreacion'),
            "usercod" => $usercod
        ];
        Renderer::render('citas/citas', $viewData);
    }
}
