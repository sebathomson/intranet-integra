<?php
session_start();
session_unset();
session_destroy();

$msgtitulo = "P&Aacute;GINA NO ENCONTRADA:";
$msgcuerpo = "La p&aacute;gina que esta buscando no existe o no esta disponible.";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es-ES">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Intranet - Integra Ingenie&iacute;a</title>
        <!-- Inicio estilos -->
        <link rel="shortcut icon" href="vista/images/favicon.ico" />
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
        <div id="login-box">
            <img src="vista/images/404.png" width="400px" height="126px" style="margin-left:-30px;padding-top:10px;" />
            <hr />
            <div id="error">
                <span id="titlerror"><?php echo $msgtitulo; ?></span>
<?php echo $msgcuerpo; ?>
            </div>
            <a id="volver" href="index.php">VOLVER</a>
        </div>
    </body>
</html>