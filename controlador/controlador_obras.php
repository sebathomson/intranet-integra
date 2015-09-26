<?php

require_once ("controlador_principal.php");

require_once (PATH_ROOT . '/modelo/obra.php');
require_once (PATH_ROOT . '/modelo/ventaservicio.php');
require_once (PATH_ROOT . '/controlador/functions/validar.php');
require_once (PATH_ROOT . '/controlador/controlador_administracion_empleados.php');

class controlador_obras {

    function obra_ver($obra_id) {

        $validar = validarID($obra_id);
        if ($validar) {

            $obra_instancia = new Obra($obra_id, 0, 0, 0, 0);
            $obra = array();
            $obra = $obra_instancia->Obra_Ver();

            if ($obra == false) {
                header("Location: ../vista/obra/obras.php?seccion=buscar");
            }
            return $obra;
        } else {
            header("Location: ../vista/obra/obras.php?seccion=buscar");
        }
    }

    function obra_buscar($busqueda, $filtro) {
        $servicio = array();

        if ($filtro == "obra_id" OR $filtro == "obra_nombre" OR $filtro == "servicio_id") {
            
        } else {
            return false;
        }
        $servicio_instancia = new Obra(0, 0, 0, 0, 0);
        $servicio = $servicio_instancia->Obra_Buscar($filtro, $busqueda);
        if ($servicio == false) {
            return false;
        } else {
            return $servicio;
        }
    }

    function servicio_buscar($busqueda, $filtro) {
        $servicio = array();

        if ($filtro == "servicio_cliente" OR $filtro == "servicio_id" OR $filtro == "servicio_nombre") {
            
        } else {
            return false;
        }
        $servicio_instancia = new VentaServicio(0, 0, 0);

        $servicio = $servicio_instancia->VtaS_Buscar($busqueda, $filtro);
        if ($servicio == false) {
            return false;
        } else {
            return $servicio;
        }
    }

    function servicio_ver($servicio_id) {
        $servicio = array();

        $servicio_instancia = new VentaServicio($servicio_id, 0, 0, 0, 0);
        $servicio = $servicio_instancia->VtaS_Ver();
        if ($servicio == false) {
            return false;
        } else {
            return $servicio;
        }
    }

    function servicio_modificar() {
        $servicio_id = $_POST["servicio_id"];
        $servicio_nombre = $_POST["servicio_nombre"];
        $servicio_descripcion = $_POST["servicio_descripcion"];

        $servicio_instancia = new VentaServicio($servicio_id, $servicio_nombre, $servicio_descripcion, 0, 0);
        $validador = $servicio_instancia->VtaS_Modificar();

        if ($validador == FALSE) {
            header("Location: ../vista/obra/servicios.php?seccion=ver&id=$servicio_id&mensaje=modificarError");
        } else {
            header("Location: ../vista/obra/servicios.php?seccion=ver&id=$servicio_id&mensaje=modificarOk");
        }
    }

    function obra_crear() {
        $obra_servicio_id = $_POST["obra_servicio_id"];
        $obra_nombre = $_POST["obra_nombre"];
        $obra_descripcion = $_POST["obra_descripcion"];

        $instancia_obra = new Obra(0, $obra_nombre, $obra_descripcion, 0, $obra_servicio_id);
        $obra_id = $instancia_obra->Obra_Nueva();

        if ($obra_id == FALSE) {
            header("Location: ../vista/obra/obras.php?seccion=ver&id=$obra_id&mensaje=crearError");
        } else {
            header("Location: ../vista/obra/obras.php?seccion=ver&id=$obra_id&mensaje=crearOk");
        }
    }

    function obra_modificar() {
        $obra_id = $_POST["obra_id"];
        $obra_nombre = $_POST["obra_nombre"];
        $obra_descripcion = $_POST["obra_descripcion"];
        $obra_estado = $_POST["obra_Estado"];

        $instancia_obra = new Obra($obra_id, $obra_nombre, $obra_descripcion, $obra_estado, 0);
        $valid = $instancia_obra->Obra_Modificar();

        $rut_supervisor = $_POST["addsupervisor"];

        $valid_addsup = 0;
        $valid_delsup = 0;
        $valid_addobr = 0;
        $valid_delobr = 0;

        if ($rut_supervisor !== "no-option") {
            $valid_addsup = $instancia_obra->Obra_Asignar_Empleado($rut_supervisor, 1, 1);
        }
        $rut_supervisor = $_POST["delsupervisor"];
        if ($rut_supervisor !== "no-option") {
            $valid_delsup = $instancia_obra->Obra_Asignar_Empleado($rut_supervisor, 1, 0);
        }
        if ($valid_addsup !== 0) {
            $valid = $valid_addsup;
        }
        if ($valid_delsup !== 0) {
            $valid = $valid_delsup;
        }
//Obreros
        $rut_obrero = $_POST["addobrero"];
        if ($rut_obrero !== "no-option") {
            $valid_addobr = $instancia_obra->Obra_Asignar_Empleado($rut_obrero, 0, 1);
        }
        $rut_obrero = $_POST["delobrero"];
        if ($rut_obrero !== "no-option") {
            $valid_delobr = $instancia_obra->Obra_Asignar_Empleado($rut_obrero, 0, 0);
        }
        if ($valid_addobr !== 0) {
            $valid = $valid_addobr;
        }
        if ($valid_delobr !== 0) {
            $valid = $valid_delobr;
        }
        if ($valid == false) {
            header("Location: ../vista/obra/obras.php?seccion=ver&id=$obra_id&mensaje=modificarError");
        } else {
            header("Location: ../vista/obra/obras.php?seccion=ver&id=$obra_id&mensaje=modificarOk");
        }
    }

}

$instancia_controlador_obras = new controlador_obras();

if (isset($_GET["obraccion"])) {
    $action = $_GET["obraccion"];
} else {
    $action = "crear";
}

switch ($action) {
    case "nuevo":
        $instancia_controlador_obras->obra_crear();
        break;
    case "modificar":
        $instancia_controlador_obras->obra_modificar();
        break;
    case "servicio_modificar":
        $instancia_controlador_obras->servicio_modificar();
        break;
}

if (isset($_POST["egreso_obra"])) {
    $action = $_POST["egreso_obra"];
} else {
    
}
?>