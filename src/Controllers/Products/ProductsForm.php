<?php

namespace Controllers\Products;

use Controllers\PublicController;
use Utilities\Site;
use Views\Renderer;
use Dao\Products\Products;
use LDAP\Result;

class ProductsForm extends PublicController
{
    private $viewData = [];
    private $modeDscArr = [
        "DSP" => "Detalle de %s (%s)",
        "INS" => "Nuevo Producto",
        "UPD" => "Editar %s (%s)",
        "DEL" => "Eliminar %s (%s)"
    ];
    private $mode = '';

    //Estructura del producto
    private $productos = [
        "productId" => 0,
        "productName" => '',
        "productDescription" => '',
        "productPrice" => 0,
        "productImgUrl" => '',
        "productStock" => 0,
        "productStatus" => 'DIS',
    ];

    public function run(): void
    {
        $this->inicializarForm();
        if($this->isPostBack()){
            $this->cargarDatosDelFormulario();
            $this->procesarAccion();
        }
        $this->generarViewData();
        Renderer::render('products/products_form', $this->viewData);
    }

    private function inicializarForm()
    {
        if (isset($_GET["mode"]) && isset($this->modeDscArr[$_GET["mode"]])) {
            $this->mode = $_GET["mode"];
        } else {
            Site::redirectToWithMsg("index.php?page=Products-ProductsList", "Algo Sucedio MAl. Intente de nuevo");
            die();
        }
        if ($this->mode!=='INS' && isset($_GET["productId"])){
            $this->productos["productId"] = $_GET["productId"];
            $this->cargarDatosProducts();
        }
    }
    private function cargarDatosProducts(){
        $tpmProducts = Products::obtenerProductsXId($this->productos["productId"]);
        $this->productos = $tpmProducts;
    }
    private function cargarDatosDelFormulario(){
        $this->productos["productName"] = $_POST["productName"];
        $this->productos["productDescription"] = $_POST["productDescription"];
        $this->productos["productPrice"] = floatval($_POST["productPrice"]);
        $this->productos["productImgUrl"] = $_POST["productImgUrl"];
        $this->productos["productStock"] = intval($_POST["productStock"]);
        $this->productos["productStatus"] = $_POST["productStatus"];
    }

    private function procesarAccion(){
        switch($this->mode){
            case 'INS':
                $result = Products::agregarProducts($this->productos);
                if($result){
                    Site::redirectToWithMsg("index.php?page=Products-ProductsList", "Producto Registrado Satisfactoriamente");
                }
                break;
            case 'UPD':
                $result = Products::actualizarProducts($this->productos);
                if($result){
                    Site::redirectToWithMsg("index.php?page=Products-ProductsList", "Producto actualizado Satisfactoriamente");
                }
                break;
            case 'DEL':
                $result = Products::eliminarProducts($this->productos['productId']);
                if($result){
                    Site::redirectToWithMsg("index.php?page=Products-ProductsList", "Producto Eliminado Satisfactoriamente");
                }
                break;
        }
    }

    private function generarViewData()
    {
        $this->viewData["mode"] = $this->mode;
        
        $this->viewData["modes_dsc"] = sprintf(
            $this->modeDscArr[$this->mode],
            $this->productos["productName"],
            $this->productos["productId"]
        );
        $this->viewData["productos"] = $this->productos;
        $this->viewData["readonly"] = 
        ($this->viewData["mode"] === 'DEL' 
        || $this->viewData["mode"] === 'DSP'
        ) ? 'readonly': '';
        $this->viewData["showConfirm"] = ($this->viewData["mode"] !== 'DSP');
    }
    
}
