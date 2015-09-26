<?php
require_once("../../controlador/controlador_ventas.php");
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
                <li><a href="servicios.php">VENTA DE SERVICIOS</a></li>
                <li id="liend"><a id="cerrarsesion" class="editprofile" href="#">[Editar]</a> <a id="cerrarsesion" href="../../controlador/controlador_principal.php?accion=desconectar">[Desconectar]</a></li>
            </ul>
        </div>
        <!-- FIN MENU -->
        <div class="clear"></div>
        <!-- INICIO CONTENEDOR -->
        <div id="contenedortop">
            <img class="left" alt="" src="../images/contenedor_corner_left_top.png"/>
            <div name="titulo">
                <span id="titleseccion">EGRESOS</span>
                <img class="left" alt="" src="../images/title_right.png"/>
            </div>
            <img class="right" alt="" src="../images/contenedor_corner_right_top.png"/>
        </div>
        <?php
        if (isset($_GET["buscar"])) {
            $busqueda = $_GET["buscar"];
        } else {
            $busqueda = "";
        }
        if (isset($_GET["tipo_egreso"])) {
            $tipo_egreso = $_GET["tipo_egreso"];
        } else {
            $tipo_egreso = "insumos";
        }
        ?>
        <div id="contenedor">
            <div class="clear"></div>
            <!-- TITULO SECCION -->
            <span id="title">BUSCAR</span>
            <!-- TITULO SECCION -->
            <div class="clear"></div>	
            <!-- CONTENIDO INICIO-->
            <!-- INICIO BUSCAR -->
            <form name="buscar" method="GET" action="">
                <input type="hidden" name="seccion" value="buscar" />
                <table id="formularios">
                    <tbody>
                        <tr>
                            <td>Tipo Egreso:</td>
                            <td>
                                <select name="tipo_egreso">
                                    <option value="insumos">INSUMOS</option>
                                    <option value="obra">OBRAS</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>RUT Cliente:</td>
                            <td><input type="text" name="buscar" /></td>
                        </tr>
                    </tbody>
                </table>
                <div class="botones">
                    <a class="agregar_solo" href="javascript:document.buscar.submit()">BUSCAR</a>
                </div>
            </form>
            <!-- FIN BUSCAR -->
            <?php
            if (isset($_GET["buscar"]) AND isset($_GET["tipo_egreso"])) {
                $busqueda = $_GET["buscar"];
                $tipo_egreso = $_GET["tipo_egreso"];
                
                $egresos = array();
                
                $instancia_controlador_ventas = new controlador_ventas();
                $egresos = $instancia_controlador_ventas->buscar_egresos("Buscar", $tipo_egreso, $busqueda);
                
                if ($egresos == false) {
                    echo "<SCRIPT type='text/javascript'>window.onload=busquedaError;</SCRIPT>";
                } else {
                    ?>
                    <!--INICIO RESULTADO BUSQUEDA-->
                    <table id="buscar" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID EGRESO</th>
                                <th>CLIENTE</th>
                                <th>FECHA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($x = 0; $x < count($egresos); $x++) {
                                $egreso_id = $egresos[$x][0];
                                $egreso_cliente = $egresos[$x][1];
                                $egreso_fecha = $egresos[$x][2];

                                echo "<tr>";
                                echo "<td><a id='enlace' href='../../controlador/functions/imprimir.php?tipo=$tipo_egreso&id=$egreso_id'>$egreso_id</a></td>";
                                echo "<td>$egreso_cliente</td>";
                                echo "<td>$egreso_fecha</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- FIN RESULTADO BUSQUEDA-->                              
                    <?php
                }
            }
            ?>
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