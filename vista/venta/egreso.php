<?php
//session_start();
error_reporting(E_ALL);
@ini_set('display_errors', '1');

require_once ("../../controlador/controlador_stockbodega.php");

if (isset($_SESSION['carro'])) {
    $carro = $_SESSION['carro'];
} else {
    $carro = false;
}

if (isset($_SESSION['venta_cabecera'])) {
    $venta_cabecera = $_SESSION['venta_cabecera'];
} else {
    $venta_cabecera = false;
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
                <li id="lifirst"><img class="left" alt="Logo" src="../images/menu_left.png" width="206px" height="45px" /></li>
                <li><a href="stock.php">AGREGAR</a></li>
                <li><a href="stock_carro.php">VER CARRO</a></li>
                <li id="liend"><a id="cerrarsesion" href="">[Editar]</a> <a id="cerrarsesion" href="../../controlador/controlador_principal.php?accion=desconectar">[Desconectar]</a></li>
            </ul>
        </div>
        <!-- FIN MENU -->
        <div class="clear"></div>
        <!-- INICIO CONTENEDOR -->
        <div id="contenedortop">
            <img class="left" alt="" src="../images/contenedor_corner_left_top.png"/>
            <div name="titulo">
                <span id="titleseccion">MATERIALES</span>
                <img class="left" alt="" src="../images/title_right.png"/>
            </div>
            <img class="right" alt="" src="../images/contenedor_corner_right_top.png"/>
        </div>
        <div id="contenedor">
            <!-- CABECERA DE VENTA -->
            <div class="clear"></div>
            <!-- TITULO SECCION -->
            <span id="title">ENCABEZADO DE VENTA</span>
            <!-- TITULO SECCION -->
            <div class="clear"></div>
            <form name="confirmaregreso" method="POST" action="../../controlador/controlador_ventas.php?">
                <div style="margin-bottom: 20px;">
                    <?php if ($venta_cabecera[3] == "insumos") { ?>
                        <table id="ver" cellspacing="0">
                            <tr>
                                <td>Rut Cliente:</td>
                                <td><?php echo $venta_cabecera[0]; ?></td>
                            </tr>
                            <tr>
                                <td>Nombre Cliente:</td>
                                <td><?php echo $venta_cabecera[1]; ?></td>
                            </tr>
                        </table>
                        <?php
                    } else {
                        ?>
                        <table id="ver" cellspacing="0">
                            <tr>
                                <td>ID Obra:</td>
                                <td><?php echo $venta_cabecera[0]; ?></td>
                            </tr>
                            <tr>
                                <td>Nombre Obra:</td>
                                <td><?php echo $venta_cabecera[1]; ?></td>
                            </tr>
                        </table>
                        <?php
                    }
                    ?>              
                    <input type="hidden" name="egreso_identificador" value="<?php echo $venta_cabecera[0]; ?>"/>
                    <input type="hidden" name="egreso_nombre" value="<?php echo $venta_cabecera[1]; ?>"/>
                    <input type="hidden" name="egreso_descripcion" value="<?php echo $venta_cabecera[2]; ?>"/>
                    <input type="hidden" name="egreso_tipo" value="<?php echo $venta_cabecera[3]; ?>"/>
                    <!-- DATOS DE LA CABECERA -->
                </div>
                <!-- CABECERA DE VENTA -->
                <div class="clear"></div>
                <!-- TITULO SECCION -->
                <span id="title">DETALLE DE VENTA</span>
                <!-- TITULO SECCION -->
                <div class="clear"></div>	
                <!-- CONTENIDO INICIO-->
                <?php
                if ($carro) {
                    ?>
                    <table id="buscar" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NOMBRE</th>
                                <th>BODEGA</th>
                                <th>CANTIDAD</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $contador = 0;
                            foreach ($carro as $k => $v) {
                                ?>
                                <tr> 
                                    <td><?php echo $v['materialID'] ?></td>
                                    <input type="hidden" name="material_<?php echo $contador; ?>_material_id" value="<?php echo $v['materialID']; ?>"/>
                                    <td><?php echo $v['material'] ?></td>
                                    <td><?php echo $v['bodega'] ?></td>
                                    <input type="hidden" name="material_<?php echo $contador; ?>_bodega_id" value="<?php echo $v['bodega']; ?>"/>
                                    <td><?php echo $v['cantidad'] ?></td>
                                    <input type="hidden" name="material_<?php echo $contador; ?>_material_cantidad" value="<?php echo $v['cantidad']; ?>"/>
                                </tr>
                                <?php $contador++;
                            } ?>
                            <input type="hidden" name="count_materiales" value="<?php echo $contador; ?>"/>
                        </tbody>
                    </table>
                </form>
                <div class="botones">
                    <a class="quitar_2" href="stock_carro.php?<?php echo SID ?>">VOLVER</a>
                    <a class="agregar_2" href="javascript:document.confirmaregreso.submit()">CONFIRMAR</a>
                </div>
            <?php } else { ?>
                <center>
                    <div id="error">El carro no posee materiales (<a id='enlace' href="stock.php?<?php echo SID ?>">AGREGAR MATERIALES</a>).</div>
                </center>
            <?php } ?>
            <!-- FIN RESULTADO BUSQUEDA-->
            <!-- CONTENIDO FIN-->	
            <div class="clear"></div>
        </div>
        <div id="contenedorbottom">
            <img class="left" alt="" src="../images/contenedor_corner_left_bottom.png"/>
            <img class="right" alt="" src="../images/contenedor_corner_right_bottom.png"/>
        </div>
        <!-- FIN CONTENEDOR -->
    </body>
    <?php
    if ($venta_cabecera == false) {
        ?>
        <script type="text/javascript">
            document.location.href='insumos.php';
        </script>
        <?php
    }
    ?>
</html>