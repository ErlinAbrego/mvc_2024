<?php

namespace Controllers\Funciones;

use Controllers\PublicController;
use Utilities\Site;
use Views\Renderer;
use Dao\Funciones\Funciones;
use Utilities\Validators;

class FuncionesForm extends PublicController
{
    private $viewData = [];
    private $modeDscArr = [
        "DSP" => "Detalle de %s (%s)",
        "INS" => "Nueva Función",
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

    private $funcion = [
        "fncod" => 0,
        "fndsc" => '',
        "fnest" => '',
        "fntyp" => ''
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
        Renderer::render('funciones/funciones_form', $this->viewData);
    }

    private function inicializarForm()
    {
        if (isset($_GET["mode"]) && isset($this->modeDscArr[$_GET["mode"]])) {
            $this->mode = $_GET["mode"];
        } else {
            Site::redirectToWithMsg("index.php?page=Funciones-FuncionesList", "Algo salió mal. Intente de nuevo.");
            die();
        }
        if ($this->mode !== 'INS' && isset($_GET["fncod"])) {
            $this->funcion["fncod"] = $_GET["fncod"];
            $this->cargarDatosFuncion();
        }
    }

    private function cargarDatosFuncion()
    {
        $tmpFuncion = Funciones::obtenerFuncionPorId($this->funcion["fncod"]);
        $this->funcion = $tmpFuncion;
    }

    private function cargarDatosDelFormulario()
    {
        $this->funcion["fncod"] = $_POST["fncod"];
        $this->funcion["fndsc"] = $_POST["fndsc"];
        $this->funcion["fnest"] = $_POST["fnest"];
        $this->funcion["fntyp"] = $_POST["fntyp"];
        $this->xssToken = $_POST["xssToken"];
    }

    private function validarDatos()
    {
        if (!$this->validarAntiXSSToken()) {
            Site::redirectToWithMsg("index.php?page=Funciones-FuncionesList", "Error al procesar la solicitud.");
        }

        if (Validators::IsEmpty($this->funcion["fncod"])) {
            $this->addError("El código de la función no puede estar vacío.", "fncod");
        }

        if (Validators::IsEmpty($this->funcion["fndsc"])) {
            $this->addError("La descripción no puede estar vacía.", "fndsc");
        }

        if (Validators::IsEmpty($this->funcion["fnest"])) {
            $this->addError("El estado no puede estar vacío.", "fnest");
        }

        if (Validators::IsEmpty($this->funcion["fntyp"])) {
            $this->addError("El tipo no puede estar vacío.", "fntyp");
        }

        return count($this->errors) === 0;
    }

    private function procesarAccion()
    {
        var_dump($this->funcion); 
        switch ($this->mode) {
            case 'INS':
                $result = Funciones::agregarFuncion($this->funcion);
                if ($result) {
                    Site::redirectToWithMsg("index.php?page=Funciones-FuncionesList", "Función registrada satisfactoriamente.");
                } else {
                    $this->addError("No se pudo agregar la función.", "global");
                }
                break;
            case 'UPD':
                $result = Funciones::actualizarFuncion($this->funcion);
                if ($result) {
                    Site::redirectToWithMsg("index.php?page=Funciones-FuncionesList", "Función actualizada satisfactoriamente.");
                } else {
                    $this->addError("No se pudo actualizar la función.", "global");
                }
                break;
            case 'DEL':
                $result = Funciones::eliminarFuncion($this->funcion['fncod']);
                if ($result) {
                    Site::redirectToWithMsg("index.php?page=Funciones-FuncionesList", "Función eliminada satisfactoriamente.");
                } else {
                    $this->addError("No se pudo eliminar la función.", "global");
                }
                break;
        }
    }


    private function generateAntiXSSToken()
    {
        $_SESSION["Funciones_Form_XSST"] = hash("sha256", time() . "Funciones_Form");
        $this->xssToken = $_SESSION["Funciones_Form_XSST"];
    }

    private function validarAntiXSSToken()
    {
        return isset($_SESSION["Funciones_Form_XSST"]) && $this->xssToken === $_SESSION["Funciones_Form_XSST"];
    }

    private function generarViewData()
    {
        $this->viewData["mode"] = $this->mode;
        $this->viewData["modes_dsc"] = sprintf(
            $this->modeDscArr[$this->mode],
            $this->funcion["fndsc"],
            $this->funcion["fncod"]
        );
        $this->viewData["funcion"] = $this->funcion;
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
