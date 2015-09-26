<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es-ES">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Intranet - Integra Ingenie&iacute;a</title>
        <!-- Inicio estilos -->
        <link rel="shortcut icon" href="vista/images/favicon.ico" />
        <link rel="stylesheet" type="text/css" href="vista/css/estilo.css" />
        <link rel="stylesheet" type="text/css" href="vista/css/login.css" />
        <link rel="stylesheet" type="text/css" href="vista/javascript/msgbox/jquery.msgbox.css" />
        <!-- Fin estilos -->
        <!-- Inicio Jscript -->
        <script type="text/javascript" src="vista/javascript/jquery.min.js"></script>
        <script type="text/javascript" src="vista/javascript/msgbox/jquery.msgbox.min.js"></script>
        <script type="text/javascript" src="vista/javascript/script.js"></script>
        <!-- Fin Jscript -->
    </head>
    <body>
        <form action="controlador/controlador_principal.php?accion=conectar" method="post">
            <div id="login-box">
                <table style="padding-top:80px;">
                    <tr>
                        <td class="login-box-name">Username:</td>
                        <td class="login-box-field"><input name="Username" onfocus="this.value='';" class="form-login" title="Username" value="Username" size="30" maxlength="30" /></td>
                    </tr>
                    <tr>
                        <td class="login-box-name">Password:</td>
                        <td class="login-box-field"><input name="Password" onfocus="this.value='';" class="form-login" title="Password" value="Password" size="30" maxlength="30" type="password" /></td>
                    </tr>
                </table>
                <input type="submit" value="INGRESAR" id="ingresar" />
            </div>
        </form>
    </body>
    <?php
    if (isset($_GET["mensaje"])) {
        $msg = $_GET["mensaje"];
        if ($msg == "loginError") {
            ?>
            <SCRIPT type="text/javascript">
                window.onload=mensaje; 
                function mensaje()
                { 
                    $.msgbox("Datos erróneos. Por favor, inténtelo otra vez.", 
                    {
                        type: "error",
                        buttons : [
                            {type: "submit", value: "Aceptar"}
                        ]
                    }); 
                }
            </SCRIPT>
            <?php
        }
    }
    ?>
</html>