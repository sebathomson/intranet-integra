<?php
require_once ('../../controlador/controlador_administracion_bodegas.php');

/*CONTROLAR EL ACCESO A LAS PÁGINAS*/
$privilegios_pagina = array();
$privilegios_pagina[0] = "ADMINISTRADOR";
$instancia_controlador_principal -> Validar_Acceso($privilegios_pagina);
/*CONTROLAR EL ACCESO A LAS PÁGINAS*/

if (isset($_GET["seccion"])) {
    $seccion = $_GET["seccion"];
} else {
    $seccion = "";
}
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
                <li id="lifirst"><a href="administracion.php"><img class="left" alt="Logo" src="../images/menu_left.png" width="206px" height="45px" /></a></li>
                <li><a href="administracion.php">ADMINISTRACI&Oacute;N</a></li>
                <li><a href="bodegas.php?seccion=crear">CREAR</a></li>
                <li><a href="bodegas.php?seccion=buscar">BUSCAR</a></li>
                <li id="liend"><a id="cerrarsesion" class="editprofile" href="#">[Editar]</a> <a id="cerrarsesion" href="../../controlador/controlador_principal.php?accion=desconectar">[Desconectar]</a></li>
            </ul>
        </div>
        <!-- FIN MENU -->
        <div class="clear"></div>
        <!-- INICIO CONTENEDOR -->
        <div id="contenedortop">
            <img class="left" alt="" src="../images/contenedor_corner_left_top.png"/>
            <div name="titulo">
                <span id="titleseccion">ADMINISTRACI&Oacute;N - BODEGA</span>
                <img class="left" alt="" src="../images/title_right.png"/>
            </div>
            <img class="right" alt="" src="../images/contenedor_corner_right_top.png"/>
        </div>
        <?php
        switch ($seccion) {
            case "buscar":
                $bodega = Array();
                $bodega = $instancia_controlador_bodega -> bodega_buscar();
                if ($bodega == false) {
                    ?>
                    <script> 
                        location.href='?seccion=crear'; 
                    </script>
                    <?php
                }
                ?>
                <div id="contenedor">
                    <div class="clear"></div>
                    <!-- TITULO SECCION -->
                    <span id="title">BUSCAR</span>
                    <!-- TITULO SECCION -->
                    <div class="clear"></div>	
                    <!-- CONTENIDO INICIO-->
                    <!-- INICIO RESULTADO-->
                    <table id="buscar" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>UBICACI&Oacute;N</th>
                                        <th>DESCRIPCI&Oacute;N</th>
                                    </tr>
                                </thead>
                        <tbody>
                            <?php
                            for ($x = 0; $x < count($bodega); $x++) {
                                $bodega_identificacion = $bodega[$x][0];
                                $bodega_ubicacion = $bodega[$x][1];
                                $bodega_observacion = $bodega[$x][2];

                                echo "<tr>";
                                echo "<td><a id='enlace' href='bodegas.php?seccion=modificar&id=$bodega_identificacion'>$bodega_identificacion</a></td>";
                                echo "<td>$bodega_ubicacion</td>";
                                echo "<td>$bodega_observacion</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- FIN RESULTADO BUSQUEDA-->
                    <!-- CONTENIDO FIN-->	
                    <div class="clear"></div>
                </div>
                <?php
                break;
            case "modificar":
                $bodega = Array();
                if (isset($_GET["id"])) {
                    $bodega_id = $_GET["id"];
                    $bodega = $instancia_controlador_bodega -> bodega_ver($bodega_id);

                    if ($bodega == false) {
                        ?>
                        <script> 
                            location.href='?seccion=buscar&mensaje=idError'; 
                        </script>
                        <?php
                    } else {
                        $bodega_id = $bodega[0][0];
                        $bodega_ubicacion = $bodega[0][1];
                        $bodega_descripcion = $bodega[0][2];
                    }
                } else {
                    ?>
                    <script> 
                        location.href='?seccion=buscar'; 
                    </script>
                    <?php
                }
                ?>
                <div id="contenedor">
                    <div class="clear"></div>
                    <!-- TITULO SECCION -->
                    <span id="title">MODIFICAR</span>
                    <!-- TITULO SECCION -->
                    <div class="clear"></div>	
                    <!-- CONTENIDO INICIO-->
                    <form name="modificarbodega" method="POST" action="../../controlador/controlador_administracion_bodegas.php?accion=modificar">
                        <input type="hidden" name="bodega_id" value="<?php echo $bodega_id; ?>" />
                        <table id="formularios" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td>Bodega ID:</td>
                                    <td><?php echo $bodega_id; ?></td>
                                </tr>
                                <tr>
                                    <td>Ubicaci&oacute;n:</td>
                                    <td><input type="text" name="bodega_ubicacion" maxlength="50" value="<?php echo $bodega_ubicacion; ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Descripci&oacute;n:</td>
                                    <td><textarea name="bodega_descripcion"  maxLength="200"><?php echo $bodega_descripcion; ?></textarea></td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                    <div class="botones">
                        <a class="quitar_2" href="JavaScript:history.back();">CANCELAR</a>
                        <a class="agregar_2" href="javascript:document.modificarbodega.submit()">MODIFICAR</a>
                    </div>
                    <!-- CONTENIDO FIN-->	
                    <div class="clear"></div>
                </div>
                <?php
                break;
            default:
                /*
                 * El default en este caso es el CREAR BODEGA.
                 */
                ?>
                <div id="contenedor">
                    <div class="clear"></div>
                    <!-- TITULO SECCION -->
                    <span id="title">NUEVO</span>
                    <!-- TITULO SECCION -->
                    <div class="clear"></div>		
                    <!-- CONTENIDO INICIO-->
                    <form name="crearbodega" method="POST" action="../../controlador/controlador_administracion_bodegas.php?accion=crear">
                        <table id="formularios">
                            <tbody>
                                <tr>
                                    <td>Ubicaci&oacute;n:</td>
                                    <td><input type="text" name="bodega_ubicacion" maxlength="50" /></td>
                                </tr>
                                <tr>
                                    <td>Descripci&oacute;n:</td>
                                    <td><textarea name="bodega_descripcion" maxLength="200"></textarea></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="botones">
                            <a class="quitar_solo" href="javascript:document.crearbodega.reset()">LIMPIAR</a>
                            <a class="agregar_solo" href="javascript:document.crearbodega.submit()">CREAR</a>
                        </div>
                    </form>
                    <!-- CONTENIDO FIN-->
                    <div class="clear"></div>
                </div>
                <?php
                break;
        }
        ?>
        <div id="contenedorbottom">
            <img class="left" alt="" src="../images/contenedor_corner_left_bottom.png"/>
            <img class="right" alt="" src="../images/contenedor_corner_right_bottom.png"/>
        </div>
        <?php include_once ("../footer.php"); ?>
        <!-- FIN CONTENEDOR -->
    </body>
</html>