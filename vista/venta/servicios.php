<?php
require_once("../../controlador/controlador_ventas.php");

/*CONTROLAR EL ACCESO A LAS PÁGINAS*/
$privilegios_pagina = array();
$privilegios_pagina[0] = "ADMINISTRADOR";
$instancia_controlador_principal -> Validar_Acceso($privilegios_pagina);
/*CONTROLAR EL ACCESO A LAS PÁGINAS*/

$clientes = array();

$clientes = $instancia_controlador_clientes -> clientes_activos();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es-ES">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Intranet - Integra Ingenie&iacute;a</title>
        <!-- Inicio estilos -->
        <link rel="shortcut icon" href="../images/favicon.ico" />
        <link rel="stylesheet" type="text/css" href="../css/estilo.css" />
        <link rel="stylesheet" type="text/css" href="../javascript/msgbox/jquery.msgbox.css" />
        <!-- Fin estilos -->
        <!-- Inicio Jscript -->
        <script type="text/javascript" src="../javascript/jquery.min.js"></script>
        <script type="text/javascript" src="../javascript/msgbox/jquery.msgbox.min.js"></script>
        <script type="text/javascript" src="../javascript/script.js"></script>
        <!-- Fin Jscript -->
    </head>
    <body>
        <!-- INICIO MENU -->
        <div name="menu">
            <ul id="menu">
                <li id="lifirst"><a href="#"><img class="left" alt="Logo" src="../images/menu_left.png" width="206px" height="45px" /></a></li>
                <li><a href="insumos.php">VENTA INSUMOS</a></li>
                <li><a href="../obra/servicios.php?seccion=buscar">BUSCAR SERVICIOS</a></li>
                <li><a href="buscar_egresos.php">EGRESOS</a></li>
                <li id="liend"><a id="cerrarsesion" class="editprofile" href="#">[Editar]</a> <a id="cerrarsesion" href="../../controlador/controlador_principal.php?accion=desconectar">[Desconectar]</a></li>
            </ul>
        </div>
        <!-- FIN MENU -->
        <div class="clear"></div>
        <!-- INICIO CONTENEDOR -->
        <div id="contenedortop">
            <img class="left" alt="" src="../images/contenedor_corner_left_top.png"/>
            <div name="titulo">
                <span id="titleseccion">VENTAS - SERVICIOS</span>
                <img class="left" alt="" src="../images/title_right.png"/>
            </div>
            <img class="right" alt="" src="../images/contenedor_corner_right_top.png"/>
        </div>
        <div id="contenedor">
            <div class="clear"></div>
            <!-- TITULO SECCION -->
            <span id="title">NUEVO</span>
            <!-- TITULO SECCION -->
            <div class="clear"></div>		
            <!-- CONTENIDO INICIO-->
            <form name="crearservicio" method="POST" action="../../controlador/controlador_ventas.php">
                <input type="hidden" name="venta_tipo" value="servicios" />
                <table id="formularios">
                    <tbody>
                        <tr>
                            <td>Cliente:</td>
                            <td>
                                <select name="servicio_cliente_rut">
                                    <option value="no-option">Seleccionar un Cliente</option>
                                    <?php
                                    if (count($clientes) == 0) {
                                        echo "<option value='no-cliente'>";
                                        echo "Sin Clientes";
                                        echo "</option>";
                                    } else {
                                        for ($i = 0; $i < count($clientes); $i++) {
                                            $rut_cliente = $clientes[$i][0];
                                            $nombre_cliente = $clientes[$i][1];
                                            
                                            echo "<option value='$rut_cliente'>";
                                            echo "($rut_cliente) $nombre_cliente";
                                            echo "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Nombre:</td>
                            <td><input type="text" name="servicio_nombre" /></td>
                        </tr>
                        <tr>
                            <td>Descripci&oacute;n:</td>
                            <td>
                                <textarea name="servicio_descripcion" style="width:15em;">Descripci&oacute;n servicio...</textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="botones">
                    <a class="quitar_solo" href="javascript:document.crearservicio.reset()">LIMPIAR</a>
                    <a class="agregar_solo" href="javascript:document.crearservicio.submit()">CREAR</a>
                </div>
            </form>
            <!-- CONTENIDO FIN-->
            <div class="clear"></div>
        </div>
        <div id="contenedorbottom">
            <img class="left" alt="" src="../images/contenedor_corner_left_bottom.png"/>
            <img class="right" alt="" src="../images/contenedor_corner_right_bottom.png"/>
        </div>
                <?php include_once ("../footer.php"); ?>
        <!-- FIN CONTENEDOR -->
    </body>
</html>