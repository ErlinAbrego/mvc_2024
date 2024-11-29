<?php

namespace Controllers\Roles;

use Controllers\PrivateController;
use Utilities\Site;
use Views\Renderer;
use Dao\Roles\Roles;
use Utilities\Validators;

class RolesForm extends PrivateController
{
    private $viewData = [];
    private $modeDscArr = [
        "DSP" => "Detalle de %s (%s)",
        "INS" => "Nuevo Rol",
        "UPD" => "Editar %s (%s)",
        "DEL" => "Eliminar %s (%s)"
    ];
    private $mode = '';

    private $errors = [];

    private $xssToken = '';

    private function addError($error, $context='global'){
        if (isset($this->errors[$context])) {
            $this->errors[$context][] = $error;
        } else {
            $this->errors[$context] = [$error];
        }
    }

    // Estructura del rol
    private $rol = [
        "rolescod" => 0,
        "rolesdsc" => '',
        "rolesest" => ''
    ];

    public function run(): void
    {
        $this->inicializarForm();
        if($this->isPostBack()){
            $this->cargarDatosDelFormulario();
            if ($this->validarDatos()) {
                $this->procesarAccion();
            }
        }
        $this->generarViewData();
        Renderer::render('roles/roles_form', $this->viewData);
    }

    private function inicializarForm()
    {
        if (isset($_GET["mode"]) && isset($this->modeDscArr[$_GET["mode"]])) {
            $this->mode = $_GET["mode"];
            if ($this->mode !== 'DSP'){
                if(!$this->isFeatureAutorized("roles_" . $this->mode . "_enabled")){
                    Site::redirectToWithMsg("index.php?page=Roles-RolesList", "Algo salió mal. Intente de nuevo.");
                }
            }
        } else {
            Site::redirectToWithMsg("index.php?page=Roles-RolesList", "Algo salió mal. Intente de nuevo.");
            die();
        }
        if ($this->mode !== 'INS' && isset($_GET["rolescod"])){
            $this->rol["rolescod"] = $_GET["rolescod"];
            $this->cargarDatosRol();
        }
    }

    private function cargarDatosRol(){
        $tmpRol = Roles::obtenerRolPorId($this->rol["rolescod"]);
        $this->rol = $tmpRol;
    }

    private function cargarDatosDelFormulario(){
        $this->rol["rolesdsc"] = $_POST["rolesdsc"];
        $this->rol["rolesest"] = $_POST["rolesest"];
        $this->xssToken = $_POST["xssToken"];
    }

    private function validarDatos()
    {
        if(!$this->validarAntiXSSToken()){
            Site::redirectToWithMsg("index.php?page=Roles-RolesList", "Error al procesar la solicitud.");
        }

        if (Validators::IsEmpty($this->rol["rolescod"])) {
            $this->addError("El código del rol no puede estar vacío.", "rolescod");
        }
        if (Validators::IsEmpty($this->rol["rolesdsc"])) {
            $this->addError("La descripción del rol no puede estar vacía.", "rolesdsc");
        }
        if (Validators::IsEmpty($this->rol["rolesest"])) {
            $this->addError("El estado del rol no puede estar vacío.", "rolesest");
        }

        return count($this->errors) === 0;
    }

    private function procesarAccion(){
        switch($this->mode){
            case 'INS':
                $result = Roles::agregarRol($this->rol);
                if($result){
                    Site::redirectToWithMsg("index.php?page=Roles-RolesList", "Rol registrado satisfactoriamente.");
                }
                break;
            case 'UPD':
                $result = Roles::actualizarRol($this->rol);
                if($result){
                    Site::redirectToWithMsg("index.php?page=Roles-RolesList", "Rol actualizado satisfactoriamente.");
                }
                break;
            case 'DEL':
                $result = Roles::eliminarRol($this->rol['rolescod']);
                if($result){
                    Site::redirectToWithMsg("index.php?page=Roles-RolesList", "Rol eliminado satisfactoriamente.");
                }
                break;
        }
    }

    private function generateAntiXSSToken(){
        $_SESSION["Roles_Form_XSST"] = hash("sha256", time()."Roles_Form");
        $this->xssToken = $_SESSION["Roles_Form_XSST"];
    }

    private function validarAntiXSSToken(){
        if(isset($_SESSION["Roles_Form_XSST"])){
            return $this->xssToken === $_SESSION["Roles_Form_XSST"];
        }
        return false;
    }

    private function generarViewData()
    {
        $this->viewData["mode"] = $this->mode;
        $this->viewData["modes_dsc"] = sprintf(
            $this->modeDscArr[$this->mode],
            $this->rol["rolesdsc"],
            $this->rol["rolescod"]
        );
        $this->viewData["rol"] = $this->rol;
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
