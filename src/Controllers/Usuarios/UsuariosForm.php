<?php

namespace Controllers\Usuarios;

use Controllers\PrivateController;
use Utilities\Site;
use Views\Renderer;
use Dao\Usuarios\Usuarios;
use Utilities\Validators;

class UsuariosForm extends PrivateController
{
    private $viewData = [];
    private $modeDscArr = [
        "DSP" => "Detalle de %s (%s)",
        "INS" => "Nuevo Usuario",
        "UPD" => "Editar %s (%s)",
        "DEL" => "Eliminar %s (%s)"
    ];
    private $mode = '';

    private $errors = [];

    private $xssToken = '';

    private function addError($error, $context = 'global')
    {
        if (isset($this->errors[$context])) {
            $this->errors[$context][] = $error;
        } else {
            $this->errors[$context] = [$error];
        }
    }

    // Estructura del usuario
    private $usuario = [
        "usercod" => 0,
        "useremail" => '',
        "username" => '',
        "userpswd" => '',
        "userfching" => '',
        "userpswdest" => '',
        "userpswdexp" => '',
        "userest" => '',
        "useractcod" => '',
        "userpswdchg" => '',
        "usertipo" => ''
    ];

    public function run(): void
    {
        $this->inicializarForm();
        if ($this->isPostBack()) {
            $this->cargarDatosDelFormulario();
            if ($this->validarDatos()) {
                $this->procesarAccion();
            }
        }
        $this->generarViewData();
        Renderer::render('usuarios/usuarios_form', $this->viewData);
    }

    private function inicializarForm()
    {
        if (isset($_GET["mode"]) && isset($this->modeDscArr[$_GET["mode"]])) {
            $this->mode = $_GET["mode"];
            if ($this->mode !== 'DSP'){
                if(!$this->isFeatureAutorized("usuarios_" . $this->mode . "_enabled")){
                    Site::redirectToWithMsg("index.php?page=Usuarios-UsuariosList", "Algo salió mal. Intente de nuevo.");
                }
            }
        } else {
            Site::redirectToWithMsg("index.php?page=Usuarios-UsuariosList", "Algo salió mal. Intente de nuevo.");
            die();
        }
        if ($this->mode !== 'INS' && isset($_GET["usercod"])) {
            $this->usuario["usercod"] = $_GET["usercod"];
            $this->cargarDatosUsuario();
        }
    }

    private function cargarDatosUsuario()
    {
        $tmpUsuario = Usuarios::obtenerUsuarioPorId($this->usuario["usercod"]);
        $this->usuario = $tmpUsuario;
    }

    private function cargarDatosDelFormulario()
    {
        $this->usuario["useremail"] = $_POST["useremail"];
        $this->usuario["username"] = $_POST["username"];
        $this->usuario["userpswd"] = $_POST["userpswd"];
        $this->usuario["userfching"] = $_POST["userfching"];
        $this->usuario["userpswdest"] = $_POST["userpswdest"];
        $this->usuario["userpswdexp"] = $_POST["userpswdexp"];
        $this->usuario["userest"] = $_POST["userest"];
        $this->usuario["useractcod"] = $_POST["useractcod"];
        $this->usuario["userpswdchg"] = $_POST["userpswdchg"];
        $this->usuario["usertipo"] = $_POST["usertipo"];
        $this->xssToken = $_POST["xssToken"];
    }

    private function validarDatos(){
        if (!$this->validarAntiXSSToken()) {
            Site::redirectToWithMsg("index.php?page=Usuarios-UsuariosList", "Error al procesar la solicitud.");
        }

        if (Validators::IsEmpty($this->usuario["useremail"])) {
            $this->addError("El email no puede estar vacío.", "useremail");
        }
        if (!filter_var($this->usuario["useremail"], FILTER_VALIDATE_EMAIL)) {
            $this->addError("Formato de email no válido.", "useremail");
        }

        if (Validators::IsEmpty($this->usuario["username"])) {
            $this->addError("El nombre de usuario no puede estar vacío.", "username");
        }

        if (Validators::IsEmpty($this->usuario["userpswd"])) {
            $this->addError("La contraseña no puede estar vacía.", "userpswd");
        }

        if (Validators::IsEmpty($this->usuario["userfching"])) {
            $this->addError("La fecha de registro no puede estar vacía.", "userfching");
        }

        if (Validators::IsEmpty($this->usuario["userpswdest"])) {
            $this->addError("El estado de la contraseña no puede estar vacío.", "userpswdest");
        }

        if (Validators::IsEmpty($this->usuario["userpswdexp"])) {
            $this->addError("La expiración de la contraseña no puede estar vacía.", "userpswdexp");
        }

        if (Validators::IsEmpty($this->usuario["userest"])) {
            $this->addError("El estado no puede estar vacío.", "userest");
        }

        if (Validators::IsEmpty($this->usuario["useractcod"])) {
            $this->addError("El código de activación no puede estar vacío.", "useractcod");
        }

        if (Validators::IsEmpty($this->usuario["userpswdchg"])) {
            $this->addError("El cambio de contraseña no puede estar vacío.", "userpswdchg");
        }

        if (Validators::IsEmpty($this->usuario["usertipo"])) {
            $this->addError("El tipo de usuario no puede estar vacío.", "usertipo");
        }

        return count($this->errors) === 0;
    }


    private function procesarAccion()
    {
        switch ($this->mode) {
            case 'INS':
                $result = Usuarios::agregarUsuario($this->usuario);
                if ($result) {
                    Site::redirectToWithMsg("index.php?page=Usuarios-UsuariosList", "Usuario registrado satisfactoriamente.");
                }
                break;
            case 'UPD':
                $result = Usuarios::actualizarUsuario($this->usuario);
                if ($result) {
                    Site::redirectToWithMsg("index.php?page=Usuarios-UsuariosList", "Usuario actualizado satisfactoriamente.");
                }
                break;
            case 'DEL':
                $result = Usuarios::eliminarUsuario($this->usuario['usercod']);
                if ($result) {
                    Site::redirectToWithMsg("index.php?page=Usuarios-UsuariosList", "Usuario eliminado satisfactoriamente.");
                }
                break;
        }
    }

    private function generateAntiXSSToken()
    {
        $_SESSION["Usuarios_Form_XSST"] = hash("sha256", time() . "Usuarios_Form");
        $this->xssToken = $_SESSION["Usuarios_Form_XSST"];
    }

    private function validarAntiXSSToken()
    {
        if (isset($_SESSION["Usuarios_Form_XSST"])) {
            return $this->xssToken === $_SESSION["Usuarios_Form_XSST"];
        }
        return false;
    }

    private function generarViewData()
    {
        $this->viewData["mode"] = $this->mode;
        $this->viewData["modes_dsc"] = sprintf(
            $this->modeDscArr[$this->mode],
            $this->usuario["username"],
            $this->usuario["usercod"]
        );
        $this->viewData["usuario"] = $this->usuario;
        $this->viewData["readonly"] =
            ($this->viewData["mode"] === 'DEL' || $this->viewData["mode"] === 'DSP') ? 'readonly' : '';
        foreach ($this->errors as $context => $errores) {
            $this->viewData[$context . '_error'] = $errores;
            $this->viewData[$context . '_haserror'] = count($errores) > 0;
        }
        $this->viewData["showConfirm"] = ($this->viewData["mode"] !== 'DSP');
        $this->generateAntiXSSToken();
        $this->viewData["xssToken"] = $this->xssToken;
    }
}
