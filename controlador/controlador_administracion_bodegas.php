<?php

require_once ("controlador_principal.php");
require_once (PATH_ROOT . '/modelo/bodega.php');
require_once (PATH_ROOT . '/controlador/functions/validar.php');

class controlador_administracion_bodegas {

    function bodega_ver($bodega_id) {
        $bodega = array();
        if (validarID($bodega_id)) {
            $bodega_instancia = new Bodega($bodega_id, 0, 0);
            $bodega = $bodega_instancia->Bod_Ver(true);

            if ($bodega == false) {
                header("Location: ../error.php");
            }
            return $bodega;
        } else {
            header("Location: ../error.php");
        }
    }

    function bodega_buscar() {
        $bodega = array();
        $bodega_instancia = new Bodega(0, 0, 0);
        $bodega = $bodega_instancia->Bod_Ver(false);
        return $bodega;
    }

    function bodega_modificar() {
        $bodega_id = $_POST["bodega_id"];
        $bodega_ubicacion = $_POST["bodega_ubicacion"];
        $bodega_observacion = $_POST["bodega_descripcion"];

        if (validarID($bodega_id)
                AND validarDescripcion($bodega_observacion)
                AND validarUbicacion($bodega_ubicacion)) {

            $bodega_instancia = new Bodega($bodega_id, $bodega_ubicacion, $bodega_observacion);
            $validador = $bodega_instancia->Bod_Modificar();

            if ($validador == FALSE) {
                header("Location: ../vista/adm/bodegas.php?seccion=modificar&id=$bodega_id&mensaje=modificarError");
            } else {
                header("Location: ../vista/adm/bodegas.php?seccion=modificar&id=$bodega_id&mensaje=modificarOk");
            }
        } else {
            header("Location: ../vista/adm/bodegas.php?seccion=modificar&id=$bodega_id&mensaje=modificarError");
        }
    }

    function bodega_crear() {
        $bodega_ubicacion = $_POST["bodega_ubicacion"];
        $bodega_observacion = $_POST["bodega_descripcion"];

        if (validarDescripcion($bodega_observacion)
                AND validarUbicacion($bodega_ubicacion)) {

            $bodega_instancia = new Bodega(0, $bodega_ubicacion, $bodega_observacion);
            $bodega_id = $bodega_instancia->Bod_Nueva();

            if ($bodega_id == FALSE) {
                header("Location: ../vista/adm/bodegas.php?seccion=crear&mensaje=crearError");
            } else {
                header("Location: ../vista/adm/bodegas.php?seccion=modificar&id=$bodega_id&mensaje=crearOk");
            }
        } else {
            header("Location: ../vista/adm/bodegas.php?seccion=crear&mensaje=crearError");
        }
    }

}

$instancia_controlador_bodega = new controlador_administracion_bodegas();

/* FUNCIONES */

if (isset($_GET["accion"])) {
    $accion = $_GET["accion"];
    switch ($accion) {
        case "modificar":
            $instancia_controlador_bodega->bodega_modificar();
            break;
        case "crear":
            $instancia_controlador_bodega->bodega_crear();
            break;
    }
}
?>