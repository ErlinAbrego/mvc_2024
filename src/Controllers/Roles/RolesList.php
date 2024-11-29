<?php
namespace Controllers\Roles;

use Controllers\PrivateController;
use Dao\Roles\Roles;
use Views\Renderer;

class RolesList extends PrivateController
{
    public function run(): void
    {
        $rolesDao = Roles::obtenerRoles();

        foreach ($rolesDao as &$rol) {
            $rol['estado_dsc'] = [
                "ACT" => "Activo",
                "INA" => "Inactivo",
                "SUS" => "Suspendido"
            ][$rol['rolesest']] ?? "Desconocido";  // Si el estado no es válido, mostramos "Desconocido"
        }

        $viewData = [
            "roles" => $rolesDao,
            "INS_enable" => $this->isFeatureAutorized('roles_INS_enabled'),
            "UPD_enable" => $this->isFeatureAutorized('roles_UPD_enabled'),
            "DEL_enable" => $this->isFeatureAutorized('roles_DEL_enabled'),
        ];
        Renderer::render('roles/roles', $viewData);
    }
}
