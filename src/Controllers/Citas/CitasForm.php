<?php
namespace Controllers\Citas;

use Controllers\PrivateController;
use Utilities\Site;
use Views\Renderer;
use Dao\Citas\Citas;
use Utilities\Validators;

class CitasForm extends PrivateController
{
    private $viewData = [];
    private $modeDscArr = [
        "DSP" => "Detalle de Cita (%s)",
        "INS" => "Nueva Cita",
        "UPD" => "Editar Cita (%s)",
        "DEL" => "Eliminar Cita (%s)"
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

    // Estructura de la cita
    private $cita = [
        "CitaID" => 0,
        "usercod" => 0,
        "FechaCita" => '',
        "TipoExamen" => '',
        "EstadoCita" => 'Pendiente', // Estado predeterminado
        "FechaCreacion" => '',
        "FechaModificacion" => ''
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
        Renderer::render('citas/citas_form', $this->viewData);
    }

    private function inicializarForm()
    {
        if (isset($_GET["mode"]) && isset($this->modeDscArr[$_GET["mode"]])) {
            $this->mode = $_GET["mode"];
            if ($this->mode !== 'DSP') {
                if(!$this->isFeatureAutorized("citas_" . $this->mode . "_enabled")){
                    Site::redirectToWithMsg("index.php?page=Citas-CitasList", "Algo salió mal. Intente de nuevo.");
                }
            }
        } else {
            Site::redirectToWithMsg("index.php?page=Citas-CitasList", "Algo salió mal. Intente de nuevo.");
            die();
        }
        if ($this->mode !== 'INS' && isset($_GET["CitaID"])) {
            $this->cita["CitaID"] = $_GET["CitaID"];
            $this->cargarDatosCita();
        }
    }

    private function cargarDatosCita()
    {
        $tmpCita = Citas::obtenerCitaPorId($this->cita["CitaID"]);
        // Establecer "Pendiente" por defecto si está vacío
        if (empty($tmpCita["EstadoCita"])) {
            $tmpCita["EstadoCita"] = "Pendiente";
        }
        $this->cita = $tmpCita;
    }

    private function cargarDatosDelFormulario()
    {
        $this->cita["usercod"] = $_POST["usercod"];
        $this->cita["FechaCita"] = $_POST["FechaCita"];
        $this->cita["TipoExamen"] = $_POST["TipoExamen"];
        $this->cita["EstadoCita"] = $_POST["EstadoCita"] ?: 'Pendiente'; // Estado predeterminado
        $this->cita["FechaCreacion"] = $_POST["FechaCreacion"];
        $this->cita["FechaModificacion"] = $_POST["FechaModificacion"];
        $this->xssToken = $_POST["xssToken"];
    }

    private function validarDatos(){
        if (!$this->validarAntiXSSToken()) {
            Site::redirectToWithMsg("index.php?page=Citas-CitasList", "Error al procesar la solicitud.");
        }

        if (Validators::IsEmpty($this->cita["usercod"])) {
            $this->addError("El código de usuario no puede estar vacío.", "usercod");
        }

        if (Validators::IsEmpty($this->cita["FechaCita"])) {
            $this->addError("La fecha de la cita no puede estar vacía.", "FechaCita");
        }

        if (Validators::IsEmpty($this->cita["TipoExamen"])) {
            $this->addError("El tipo de examen no puede estar vacío.", "TipoExamen");
        }

        if (Validators::IsEmpty($this->cita["EstadoCita"])) {
            $this->addError("El estado de la cita no puede estar vacío.", "EstadoCita");
        }

        return count($this->errors) === 0;
    }

    private function procesarAccion()
    {
        switch ($this->mode) {
            case 'INS':
                $result = Citas::agregarCita($this->cita);
                if ($result) {
                    Site::redirectToWithMsg("index.php?page=Citas-CitasList", "Cita registrada satisfactoriamente.");
                }
                break;
            case 'UPD':
                $result = Citas::actualizarCita($this->cita);
                if ($result) {
                    Site::redirectToWithMsg("index.php?page=Citas-CitasList", "Cita actualizada satisfactoriamente.");
                }
                break;
            case 'DEL':
                $result = Citas::eliminarCita($this->cita['CitaID']);
                if ($result) {
                    Site::redirectToWithMsg("index.php?page=Citas-CitasList", "Cita eliminada satisfactoriamente.");
                }
                break;
        }
    }

    private function generateAntiXSSToken()
    {
        $_SESSION["Citas_Form_XSST"] = hash("sha256", time() . "Citas_Form");
        $this->xssToken = $_SESSION["Citas_Form_XSST"];
    }

    private function validarAntiXSSToken()
    {
        if (isset($_SESSION["Citas_Form_XSST"])) {
            return $this->xssToken === $_SESSION["Citas_Form_XSST"];
        }
        return false;
    }

    private function generarViewData()
    {
        $this->viewData["mode"] = $this->mode;
        $this->viewData["modes_dsc"] = sprintf(
            $this->modeDscArr[$this->mode],
            $this->cita["TipoExamen"],
            $this->cita["CitaID"]
        );
        $this->viewData["cita"] = $this->cita;
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
