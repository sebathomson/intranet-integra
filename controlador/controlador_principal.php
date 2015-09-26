<?php

if (session_start()) { /**/
} else {
    session_start();
}
if (defined('PATH_ROOT')) { /* ... */
} else {
    define("PATH_ROOT", $_SERVER['DOCUMENT_ROOT'] . "/taller/");
}

require_once (PATH_ROOT . '/modelo/usuario.php');
require_once (PATH_ROOT . '/controlador/functions/validar.php');

class controlador_principal {

    function Iniciar_Sesion($usuario_username, $usuario_password) {

        if (validarUsername($usuario_username) AND validarPassword($usuario_password)) {

            $instancia_usuario = new Usuario($usuario_username, $usuario_password, 0, 0);
            $validador = $instancia_usuario->User_Validar();
            if ($validador !== 0) {
                if (session_start()) {
                    $session_id = md5($usuario_username);
                    $session_username = $usuario_username;
                    $_SESSION["session_id"] = $session_id;
                    $_SESSION["session_username"] = $session_username;

                    $usuario_rut = $instancia_usuario->User_getRut();
                    $instancia_usuario->usuario_rut_empleado = $usuario_rut;
                    $usuario_array = $instancia_usuario->User_Ver();

                    $tipo_usuario = $usuario_array[3];
                    
                    $_SESSION["session_privilegio"] = $usuario_array[3];

                    switch ($tipo_usuario) {
                        case "ADMINISTRADOR":
                            header('Location: ../vista/adm/administracion.php?mensaje=welcome');
                            break;
                        case "VENDEDOR":
                            $_SESSION['venta_cabecera'];
                            header('Location: ../vista/venta/insumos.php?mensaje=welcome');
                            break;
                        case "BODEGUERO":
                            header('Location: ../vista/bodega/materiales.php?mensaje=welcome');
                            break;
                        case "NORMAL":
                            header('Location: ../vista/stock/stock.php?mensaje=welcome');
                            break;
                        default:
                            header('Location: ../error.php');
                            break;
                    }
                } else {
                    header('Location: ../index.php?mensaje=loginError');
                }
            } else {
                header('Location: ../index.php?mensaje=loginError');
            }
        } else {
            header('Location: ../index.php?mensaje=loginError');
        }
    }

    function Desconectar() {
        if (isset($_SESSION["session_id"])) {
            session_unset();
            session_destroy();
            header("Location: ../index.php");
        } else {
            header("Location: ../index.php");
        }
    }

    function Validar_Acceso($privilegios_pagina) {
        $instancia_controlador_principal_inside = new controlador_principal();

        if (!isset($_SESSION["session_username"])) {
            $instancia_controlador_principal_inside->Desconectar();
        } else {

            $session_username = $_SESSION["session_username"];

            $instancia_usuario = new Usuario($session_username, 0, 0, 0);

            $usuario_rut = $instancia_usuario->User_getRut();

            if ($usuario_rut == false) {
                $instancia_controlador_principal_inside->Desconectar();
            }

            $usuario_array = $instancia_usuario->User_Ver();

            $tipo_usuario = $usuario_array[3];

            if (!in_array($tipo_usuario, $privilegios_pagina)) {
                $instancia_controlador_principal_inside->Desconectar();
            }
        }
    }

}

$instancia_controlador_principal = new controlador_principal();

if (isset($_GET["accion"])) {
    $seccion = $_GET["accion"];
    switch ($seccion) {
        case "conectar":
            if (isset($_POST["Username"], $_POST["Password"])) {
                $usuario_username = $_POST["Username"];
                $usuario_password = $_POST["Password"];
                $instancia_controlador_principal->Iniciar_Sesion($usuario_username, $usuario_password);
            } else {
                header('Location: ../index.php?mensaje=loginError');
            }
            break;
        case "desconectar":
            $instancia_controlador_principal->Desconectar();
            break;
        case "editar_password":
            $usuario_password_new = $_POST["password_new"];
            $usuario_password_rep = $_POST["password_rep"];
            $usuario_password_old = $_POST["password_old"];
            $url = $_POST["url"];

            $url = str_replace("#", "", $url);

            $usuario_username = $_SESSION["session_username"];

            $instacia_usuario = new Usuario($usuario_username, $usuario_password_old, 0, 0);

            $validador = $instacia_usuario->User_Validar();

            if ($validador !== 0) {

                if ($usuario_password_new == $usuario_password_rep) {

                    if ($instacia_usuario->User_Modificar_password($usuario_username, $usuario_password_new)) {
                        $_SESSION["session_editar_password"] = "passwordOk";
                        header("Location: $url");
                    } else {
                        $_SESSION["session_editar_password"] = "passwordError";
                        header("Location: $url");
                    }
                } else {
                    $_SESSION["session_editar_password"] = "passwordError";
                    header("Location: $url");
                }
            } else {
                $_SESSION["session_editar_password"] = "passwordError";
                header("Location: $url");
            }
            break;
        default:
            break;
            header('Location: ../index.php');
    }
} else {
    //header('Location: ../index.php');
}
?>