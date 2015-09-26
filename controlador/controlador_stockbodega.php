<?php

require_once ("controlador_principal.php");

require_once (PATH_ROOT . '/modelo/stockbodega.php');
require_once (PATH_ROOT . '/modelo/bodega.php');
require_once (PATH_ROOT . '/modelo/material.php');
require_once (PATH_ROOT . '/controlador/controlador_administracion_proveedores.php');
require_once (PATH_ROOT . '/controlador/functions/validar.php');

class controlador_stockbodega {

//FUNCIONES
    function ver_stock($material_identificacion) {

        $material = array();

        $material_instancia = new StockBodega(0, 0, 0, $material_identificacion, 0);

        $material = $material_instancia->Stock_Buscar();

        return $material;
    }

    function ver_todo() {
        $materiales = array();

        $material_instancia = new StockBodega(0, 0, 0, 0, 0);

        $materiales = $material_instancia->Stock_Ver_Todo();

        return $materiales;
    }

    function stock_agregar() {

        $material_id = $_POST["material_id"];

        $instanciasBodega = new Bodega(0, 0, 0);

        $bodega_array = array();
        $bodega_array = $instanciasBodega->Bod_Ver(false);

        for ($count = 0; $count < count($bodega_array); $count++) {

            $bodega_id = $bodega_array[$count][0];

            if (isset($_POST["agregar_stock_$bodega_id"])
                    AND is_numeric($_POST["agregar_stock_$bodega_id"])
            ) {
                $cantidad = $_POST["agregar_stock_$bodega_id"];
                
                $instanciasStockBodega = new StockBodega($cantidad, 0, 0, $material_id, $bodega_id);
                $validador = $instanciasStockBodega->Stock_Agregar();
                unset($instanciasStockBodega);

                if ($validador == false) {
                    header("Location: ../vista/bodega/materiales.php?seccion=ver&id=$material_id&mensaje=modificarError");
                } else {
                    header("Location: ../vista/bodega/materiales.php?seccion=ver&id=$material_id&mensaje=modificarOk");
                }
            } else {
                header("Location: ../vista/bodega/materiales.php?seccion=ver&id=$material_id&mensaje=modificarError");
            }
        }
    }

}

$instancia_controlador_stockbodega = new controlador_stockbodega();
//Switch-Case
if (isset($_GET["accion"])) {
    $accion = $_GET["accion"];
    switch ($accion) {
        case "stockagregar":
            $instancia_controlador_stockbodega->stock_agregar();
            break;
    }
}
?>