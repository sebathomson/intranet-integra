<?php

require_once ("controlador_principal.php");

require_once (PATH_ROOT . '/modelo/cliente.php');
require_once (PATH_ROOT . '/controlador/functions/validar.php');

class controlador_adminitracion_clientes {

//FUNCIONES

    function cliente_ver($clientes_rut) {
        $clientes = array();
        if (validarRut($clientes_rut)) {
            $clientes_instancia = new Cliente($clientes_rut, 0, 0, 0, 0, 0);
            $clientes = $clientes_instancia->Cli_Ver();
            return $clientes;
        } else {
            return false;
        }
    }

    function cliente_buscar($busqueda, $filtro, $activacion) {
        $cliente = array();

        if ($filtro == "cliente_rut" OR $filtro == "cliente_nombre") {
            
        } else {
            return false;
        }

        $cliente_instancia = new Cliente(0, 0, 0, 0, 0, 0);

        $cliente = $cliente_instancia->Cli_Buscar($filtro, $busqueda, $activacion);

        return $cliente;
    }

    function clientes_activos() {
        $cliente = array();

        $cliente_instancia = new Cliente(0, 0, 0, 0, 0, 0);

        $cliente = $cliente_instancia->Cli_Get_lista();

        return $cliente;
    }

    function cliente_modificar() {
        $cliente_rut = $_POST["cliente_rut"];
        $cliente_nombre = $_POST["cliente_nombre"];
        $cliente_correo = $_POST["cliente_correo"];
        $cliente_direccion = $_POST["cliente_direccion"];
        $cliente_movil = $_POST["cliente_movil"];
        $cliente_fijo = $_POST["cliente_fijo"];
        $cliente_estado = $_POST["cliente_estado"];

        if (validarRut($cliente_rut) AND
                validarNombre($cliente_nombre) AND
                validarEmail($cliente_correo) AND
                validarUbicacion($cliente_direccion) AND
                validarFonoFijo($cliente_fijo) AND
                validarFonoMovil($cliente_movil)) {

            $cliente_instancia = new Cliente($cliente_rut, $cliente_nombre, $cliente_correo, $cliente_direccion, $cliente_fijo, $cliente_movil);

            $validador = $cliente_instancia->Cli_Modificar($cliente_estado);

            if ($validador == FALSE) {
                header("Location: ../vista/adm/clientes.php?seccion=ver&id=$cliente_rut&mensaje=modificarError");
            } else {
                header("Location: ../vista/adm/clientes.php?seccion=ver&id=$cliente_rut&mensaje=modificarOk");
            }
        } else {
            header("Location: ../vista/adm/clientes.php?seccion=ver&id=$cliente_rut&mensaje=modificarError");
        }
    }

    function cliente_crear() {
        $cliente_rut = $_POST["cliente_rut"];
        $cliente_nombre = $_POST["cliente_nombre"];
        $cliente_correo = $_POST["cliente_correo"];
        $cliente_direccion = $_POST["cliente_direccion"];
        $cliente_movil = $_POST["cliente_movil"];
        $cliente_fijo = $_POST["cliente_fijo"];

        if (validarRut($cliente_rut) AND
                validarRutGuion($cliente_rut) AND
                validarNombre($cliente_nombre) AND
                validarEmail($cliente_correo) AND
                validarUbicacion($cliente_direccion) AND
                validarFonoFijo($cliente_fijo) AND
                validarFonoMovil($cliente_movil)) {

            $cliente_instancia = new Cliente($cliente_rut, $cliente_nombre, $cliente_correo, $cliente_direccion, $cliente_fijo, $cliente_movil);

            $validador = $cliente_instancia->Cli_Nuevo();

            if ($validador == FALSE) {
                header("Location: ../vista/adm/clientes.php?seccion=crear&mensaje=crearError");
            } else {
                header("Location: ../vista/adm/clientes.php?seccion=ver&id=$cliente_rut&mensaje=crearOk");
            }
        } else {
            header("Location: ../vista/adm/clientes.php?seccion=crear&mensaje=crearError");
        }
    }

}

$instancia_controlador_clientes = new controlador_adminitracion_clientes();
//Switch-Case
if (isset($_GET["accion"])) {
    $accion = $_GET["accion"];
    switch ($accion) {
        case "modificar":
            $instancia_controlador_clientes->cliente_modificar();
            break;
        case "crear":
            $instancia_controlador_clientes->cliente_crear();
            break;
    }
}
?>