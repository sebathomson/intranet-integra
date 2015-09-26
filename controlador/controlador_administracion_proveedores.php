<?php

require_once ("controlador_principal.php");

require_once (PATH_ROOT . '/modelo/proveedor.php');
require_once (PATH_ROOT . '/controlador/functions/validar.php');

//FUNCIONES

class controlador_administracion_proveedores {

    function proveedor_ver($proveedor_rut) {
        $proveedor = array();
        if (validarRut($proveedor_rut)) {
            $proveedor_instancia = new Proveedor($proveedor_rut, 0, 0, 0, 0, 0);
            $proveedor = $proveedor_instancia->Prov_Ver();
            return $proveedor;
        } else {
            return false;
        }
    }

    function proveedor_buscar($busqueda, $filtro, $activacion) {
        $proveedor = array();

        if ($filtro == "proveedor_rut" OR $filtro == "proveedor_nombre") {
            
        } else {
            return false;
        }
        
        $proveedor_instancia = new Proveedor(0, 0, 0, 0, 0, 0);
        
        $proveedor = $proveedor_instancia->Prov_Buscar($filtro, $busqueda, $activacion);
        
        if ($proveedor == false) {
            return false;
        } else {
            return $proveedor;
        }
    }

    function proveedores_activos() {
        
        $proveedor = array();
        
        $proveedor_instancia = new Proveedor(0, 0, 0, 0, 0, 0);
        
        $proveedor = $proveedor_instancia->getProveedor();
        
        return $proveedor;
    }

    function proveedor_modificar($vista_proveedor) {
        $proveedor_rut = $_POST["proveedor_rut"];
        $proveedor_nombre = $_POST["proveedor_nombre"];
        $proveedor_correo = $_POST["proveedor_correo"];
        $proveedor_direccion = $_POST["proveedor_direccion"];
        $proveedor_movil = $_POST["proveedor_movil"];
        $proveedor_fijo = $_POST["proveedor_fijo"];
        $proveedor_estado = $_POST["proveedor_estado"];
        
        if (validarRut($proveedor_rut) AND
                validarRutGuion($proveedor_rut) AND
                validarNombre($proveedor_nombre) AND
                validarEmail($proveedor_correo) AND
                validarUbicacion($proveedor_direccion) AND
                validarFonoFijo($proveedor_fijo) AND
                validarFonoMovil($proveedor_movil)) {
        
            $proveedor_instancia = new Proveedor($proveedor_rut, $proveedor_nombre, $proveedor_correo, $proveedor_direccion, $proveedor_fijo, $proveedor_movil);
            
            $validador = $proveedor_instancia->Prov_Modificar($proveedor_estado);
            
            if ($validador == FALSE) {
                header("Location: ../vista/$vista_proveedor/proveedores.php?seccion=ver&id=$proveedor_rut&mensaje=modificarError");
            } else {
                header("Location: ../vista/$vista_proveedor/proveedores.php?seccion=ver&id=$proveedor_rut&mensaje=modificarOk");
            }
        } else {
            header("Location: ../vista/$vista_proveedor/proveedores.php?seccion=ver&id=$proveedor_rut&mensaje=modificarError");
        }
    }

    function proveedor_crear($vista_proveedor) {
        $proveedor_rut = $_POST["proveedor_rut"];
        $proveedor_nombre = $_POST["proveedor_nombre"];
        $proveedor_correo = $_POST["proveedor_correo"];
        $proveedor_direccion = $_POST["proveedor_direccion"];
        $proveedor_movil = $_POST["proveedor_movil"];
        $proveedor_fijo = $_POST["proveedor_fijo"];
        if (validarRut($proveedor_rut) AND
                validarNombre($proveedor_nombre) AND
                validarEmail($proveedor_correo) AND
                validarUbicacion($proveedor_direccion) AND
                validarFonoFijo($proveedor_fijo) AND
                validarFonoMovil($proveedor_movil)) {

            $proveedor_instancia = new Proveedor($proveedor_rut, $proveedor_nombre, $proveedor_correo, $proveedor_direccion, $proveedor_fijo, $proveedor_movil);
            
            $validador = $proveedor_instancia->Prov_Nuevo();
            if ($validador == FALSE) {
                header("Location: ../vista/$vista_proveedor/proveedores.php?seccion=crear&mensaje=crearError");
            } else {
                header("Location: ../vista/$vista_proveedor/proveedores.php?seccion=ver&id=$proveedor_rut&mensaje=crearOk");
            }
        } else {
            header("Location: ../vista/$vista_proveedor/proveedores.php?seccion=crear&mensaje=crearError");
        }
    }

}

$controlador_instancia_prov = new controlador_administracion_proveedores();
//Switch-Case
if (isset($_GET["accion"])) {
    $accion = $_GET["accion"];

    if (isset($_POST["proveedor_vista"])) {
        $vista_proveedor = "bodega";
    } else {
        $vista_proveedor = "adm";
    }
    switch ($accion) {
        case "modificar":
            $controlador_instancia_prov -> proveedor_modificar($vista_proveedor);
            break;
        case "crear":
            $controlador_instancia_prov -> proveedor_crear($vista_proveedor);
            break;
    }
}
?>