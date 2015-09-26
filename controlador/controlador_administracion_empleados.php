<?php

require_once ("controlador_principal.php");

require_once (PATH_ROOT . '/modelo/empleado.php');
require_once (PATH_ROOT . '/controlador/functions/validar.php');


class controlador_administracion_empleados {

//FUNCIONES
    function empleados_ver($empleado_rut) {
        $empleado = array();
        if (validarRut($empleado_rut)) {
            $empleado_instancia = new Empleado($empleado_rut, 0, 0, 0, 0, 0, 0, 0, 0);
            $empleado = $empleado_instancia->Emp_Ver();
            return $empleado;
        } else {
            return false;
        }
    }

    function empleados_buscar($busqueda, $filtro, $activacion) {
        $empleado = array();

        if ($filtro == "empleado_rut" OR $filtro == "empleado_nombre") {
            
        } else {
            return false;
        }

        $empleado_instancia = new Empleado(0, 0, 0, 0, 0, 0, 0, 0, 0);
        $empleado = $empleado_instancia->Emp_Buscar($filtro, $busqueda, $activacion);
        return $empleado;
    }

    function empleados_listar($obra_id, $tipo) {
        $empleado = array();
        $empleado_instancia = new Empleado(0, 0, 0, 0, 0, 0, 0, 0, 0);
        if ($obra_id == "") {
            $empleado = $empleado_instancia->Emp_Buscar("empleado_nombre", "", 1);
        } else {
            if ($tipo == "obrero") {
                $empleado = $empleado_instancia->Emp_Buscar("empleado_obra_obreros", $obra_id, 1);
            } else {
                $empleado = $empleado_instancia->Emp_Buscar("empleado_obra_supervisor", $obra_id, 1);
            }
        }
        return $empleado;
    }

    function getTiposEmpleados() {
        $empleado = array();
        $empleado_instancia = new Empleado(0, 0, 0, 0, 0, 0, 0, 0, 0);
        $empleado = $empleado_instancia->User_getTiposEmpleados();
        return $empleado;
    }

    function empleados_modificar() {
        $empleado_rut = $_POST["empleado_rut"];
        $empleado_nombre = $_POST["empleado_nombre"];
        $empleado_apellido_paterno = $_POST["empleado_ap"];
        $empleado_apellido_materno = $_POST["empleado_am"];
        $empleado_correo = $_POST["empleado_correo"];
        $empleado_direccion = $_POST["empleado_direccion"];
        $empleado_fono_fijo = $_POST["empleado_fijo"];
        $empleado_fono_movil = $_POST["empleado_movil"];
        $empleado_tipo = $_POST["empleado_tipo"];
        $empleado_estado = $_POST["empleado_estado"];

        if (validarRut($empleado_rut) AND
                validarNombre($empleado_nombre) AND
                validarNombre($empleado_apellido_paterno) AND
                validarNombre($empleado_apellido_materno) AND
                validarEmail($empleado_correo) AND
                validarUbicacion($empleado_direccion) AND
                validarFonoFijo($empleado_fono_fijo) AND
                validarFonoMovil($empleado_fono_movil)) {

            $empleado_instancia = new Empleado($empleado_rut, $empleado_nombre, $empleado_apellido_paterno, $empleado_apellido_materno, $empleado_correo, $empleado_direccion, $empleado_fono_fijo, $empleado_fono_movil, $empleado_tipo);

            $validador = $empleado_instancia->Emp_Modificar($empleado_estado);

            if ($validador == FALSE) {
                header("Location: ../vista/adm/empleados.php?seccion=ver&id=$empleado_rut&mensaje=modificarError");
            } else {
                header("Location: ../vista/adm/empleados.php?seccion=ver&id=$empleado_rut&mensaje=modificarOk");
            }
        } else {
            header("Location: ../vista/adm/empleados.php?seccion=ver&id=$empleado_rut&mensaje=modificarError");
        }
    }

    function empleados_crear() {
        $empleado_rut = $_POST["empleado_rut"];
        $empleado_nombre = $_POST["empleado_nombre"];
        $empleado_apellido_paterno = $_POST["empleado_ap"];
        $empleado_apellido_materno = $_POST["empleado_am"];
        $empleado_correo = $_POST["empleado_correo"];
        $empleado_direccion = $_POST["empleado_direccion"];
        $empleado_fono_fijo = $_POST["empleado_fijo"];
        $empleado_fono_movil = $_POST["empleado_movil"];
        $empleado_tipo = $_POST["empleado_tipo"];

        if (validarRut($empleado_rut) AND
                validarRutGuion($empleado_rut) AND
                validarNombre($empleado_nombre) AND
                validarNombre($empleado_apellido_paterno) AND
                validarNombre($empleado_apellido_materno) AND
                validarEmail($empleado_correo) AND
                validarUbicacion($empleado_direccion) AND
                validarFonoFijo($empleado_fono_fijo) AND
                validarFonoMovil($empleado_fono_movil)) {

            $empleado_instancia = new Empleado($empleado_rut, $empleado_nombre, $empleado_apellido_paterno, $empleado_apellido_materno, $empleado_correo, $empleado_direccion, $empleado_fono_fijo, $empleado_fono_movil, $empleado_tipo);

            $validador = $empleado_instancia->Emp_Nuevo();

            if ($validador == FALSE) {
                header("Location: ../vista/adm/empleados.php?seccion=crear&mensaje=crearError");
            } else {
                header("Location: ../vista/adm/empleados.php?seccion=ver&id=$empleado_rut&mensaje=crearOk");
            }
        } else {
            header("Location: ../vista/adm/empleados.php?seccion=crear&mensaje=crearError");
        }
    }

}

$instancia_controlador_empleados = new controlador_administracion_empleados();

//Switch-Case
if (isset($_GET["accion"])) {
    $accion = $_GET["accion"];
    switch ($accion) {
        case "modificar":
            $instancia_controlador_empleados->empleados_modificar();
            break;
        case "crear":
            $instancia_controlador_empleados->empleados_crear();
            break;
    }
}
?>