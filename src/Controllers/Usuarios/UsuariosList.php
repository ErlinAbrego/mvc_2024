<?php

namespace Controllers\Usuarios;
use Controllers\PrivateController;
use Dao\Usuarios\Usuarios;
use Views\Renderer;

class UsuariosList extends PrivateController
{
    public function run(): void
    {
        $usuariosDao = Usuarios::obtenerUsuarios();

        foreach ($usuariosDao as &$usuario) {
            $usuario['estado_dsc'] = [
                "ACT" => "Activo",
                "INA" => "Inactivo",
                "SUS" => "Suspendido"
            ][$usuario['userest']] ?? "Desconocido";
            
            $usuario['pswd_estado_dsc'] = [
                "ACT" => "Contraseña Activa",
                "EXP" => "Contraseña Expirada"
            ][$usuario['userpswdest']] ?? "Desconocido";
        }
        $viewData = [
            "usuarios" => $usuariosDao,
            "INS_enable" => $this->isFeatureAutorized('usuarios_INS_enabled'),
            "UPD_enable" => $this->isFeatureAutorized('usuarios_UPD_enabled'),
            "DEL_enable" => $this->isFeatureAutorized('usuarios_DEL_enabled'),
            "pswd_enable" => $this->isFeatureAutorized('usuarios_pswd'),
            "cdgAct_enable" => $this->isFeatureAutorized('usuarios_cdgAct'),
            "tipoUsuario_enable" => $this->isFeatureAutorized('usuarios_tipoUsuario'),
            "Email_enable" => $this->isFeatureAutorized('usuarios_email'),
            "usercod_enable" => $this->isFeatureAutorized('usuarios_usercod'),
        ];

        Renderer::render('usuarios/usuarios', $viewData);
    }
}
