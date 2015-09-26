<?php

require_once ("controlador_principal.php");

require_once (PATH_ROOT . '/modelo/usuario.php');
require_once (PATH_ROOT . '/controlador/functions/validar.php');

class controlador_administracion_usuarios {

//FUNCIONES
    function usuario_ver($usuario_rut) {
        
        $usuario = array();
        if (validarRut($usuario_rut)) {
            $usuario_instancia = new Usuario(0, 0, 0, $usuario_rut);
            $usuario = $usuario_instancia->User_Ver();
            return $usuario;
        } else {
            return false;
        }
    }

    function usuario_buscar($busqueda, $filtro, $activacion) {
        $usuario = array();
        if ($filtro == "usuario_rut" OR $filtro == "usuario_nombre") {
            
        } else {
            return false;
        }
        
        $usuario_instancia = new Usuario(0, 0, 0, 0);
        
        $usuario = $usuario_instancia->User_Buscar($filtro, $busqueda, $activacion);
        
        return $usuario;
    }

    function getRut() {
        $session_username = $_SESSION["session_username"];
        
        $instacia_usuario = new Usuario($session_username, 0, 0, 0, 0);
        
        $rut_username = $instacia_usuario->User_getRut();
        
        return $rut_username;
    }

    function getTiposUsuarios() {
        
        $tipos = array();
        
        $instacia_usuario = new Usuario(0, 0, 0, 0, 0);
        
        $tipos = $instacia_usuario->User_getTiposUsuarios();
        
        return $tipos;
    }

    function getEmpleadosSinUser() {
        
        $empleados = array();
        
        $instacia_usuario = new Usuario(0, 0, 0, 0, 0);
        
        $empleados = $instacia_usuario->User_getEmpleadosSinUser();
        
        return $empleados;
    }

    function usuario_modificar() {
        $usuario_nombre = $_POST["usuario_nombre"];
        $usuario_rut = $_POST["usuario_rut"];
        $usuario_tipo = $_POST["usuario_tipo"];
        $usuario_estado = $_POST["usuario_estado"];

        if (empty($_POST["usuario_new_pass"])) {
            $usuario_new_pass = false;
            
            $validador = true;
            
        } else {
            $usuario_new_pass = $_POST["usuario_new_pass"];
            
            $validador = validarPassword($usuario_new_pass);
        }

        $usuario_instancia = new Usuario($usuario_nombre, $usuario_new_pass, $usuario_tipo, 0);
        
        if ($validador) {

            $validador = $usuario_instancia->User_Modificar($usuario_estado);

            if ($validador == false) {
                header("Location: ../vista/adm/usuarios.php?seccion=ver&id=$usuario_rut&mensaje=modificarError");
            } else {
                header("Location: ../vista/adm/usuarios.php?seccion=ver&id=$usuario_rut&mensaje=modificarOk");
            }
        } else {
            header("Location: ../vista/adm/usuarios.php?seccion=ver&id=$usuario_rut&mensaje=modificarError");
        }
    }

    function usuario_crear() {
        $usuario_rut_empleado = $_POST["usuario_rut_empleado"];
        $usuario_nombre = $_POST["usuario_nombre"];
        $usuario_tipo = $_POST["usuario_tipo"];
        if (validarRut($usuario_rut_empleado) AND
                validarUsername($usuario_nombre) AND
                $usuario_tipo !== "no_option") {
            $usuario_instancia = new Usuario($usuario_nombre, 0, $usuario_tipo, $usuario_rut_empleado);
            $validador = $usuario_instancia->User_Nuevo();
            if ($validador == FALSE) {
                header("Location: ../vista/adm/usuarios.php?seccion=crear&mensaje=crearError");
            } else {
                header("Location: ../vista/adm/usuarios.php?seccion=ver&id=$usuario_rut_empleado&mensaje=crearOk");
            }
        } else {
            header("Location: ../vista/adm/usuarios.php?seccion=crear&mensaje=crearError");
        }
    }

}

$instancia_controlador_usuario = new controlador_administracion_usuarios();
//Switch-Case
if (isset($_GET["accion"])) {
    $accion = $_GET["accion"];
    switch ($accion) {
        case "modificar":
            $instancia_controlador_usuario -> usuario_modificar();
            break;
        case "crear":
            $instancia_controlador_usuario -> usuario_crear();
            break;
    }
}
?>