<?php
ob_start("ob_gzhandler");
session_start();

require_once ('../../controlador/controlador_stockbodega.php');
require_once ('../../controlador/controlador_materiales.php');

/*CONTROLAR EL ACCESO A LAS PÁGINAS*/
$privilegios_pagina = array();
$privilegios_pagina[0] = "ADMINISTRADOR";
$privilegios_pagina[1] = "VENDEDOR";
$instancia_controlador_principal -> Validar_Acceso($privilegios_pagina);
/*CONTROLAR EL ACCESO A LAS PÁGINAS*/

if (isset($_SESSION['carro'])) {
    $carro = $_SESSION['carro'];
} else {
    $carro = false;
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
            <div class="clear"></div>
            <!-- TITULO SECCION -->
            <span id="title">INVENTARIO</span>
            <!-- TITULO SECCION -->
            <div class="clear"></div>	
            <!-- CONTENIDO INICIO-->
            <?php $productos = $instancia_controlador_stockbodega->ver_todo(); ?>
            <div style="float:right;margin-right: 50px;margin-top: 20px;">
                <a class="ver_carro" href="stock_carro.php?<?php echo SID ?>">VER CARRO</a>
            </div>
            <!-- INICIO RESULTADO BUSQUEDA-->
            <table id="buscar" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>CATEGOR&Iacute;A</th>
                        <th>NOMBRE</th>
                        <th>BODEGA</th>
                        <th>STOCK</th>
                        <th width="50px">AGREGAR/QUITAR</th>
                    </tr>
                </thead>
                <tbody>    
                    <?php
                    for ($x = 0; $x < count($productos); $x++) {
                        $producto_id = $productos[$x][0];
                        $producto_categoria = $productos[$x][1];
                        $producto_nombre = $productos[$x][2];
                        $producto_stock = $productos[$x][3];
                        $producto_bodega = $productos[$x][4];
                        
                        $cod = $producto_id."-".$producto_bodega;
                        
                        echo "<tr>";
                        echo "<td>$producto_id</td>";
                        echo "<td>$producto_categoria</td>";
                        echo "<td>$producto_nombre</td>";
                        echo "<td>$producto_bodega</td>";
                        echo "<td>$producto_stock</td>";
                        echo "<td>";
                        if (!$carro || !isset($carro[md5($cod)]['identificador']) || $carro[md5($cod)]['identificador'] != md5($cod)) {
                            ?>
                            <a href="../../controlador/functions/agregacar.php?<?php echo SID . "&" ?>id=<?php echo $producto_id."&bod=$producto_bodega"; ?>"><img src="../images/productonoagregado.png" width="32" height="32" border="0" title="Agregar" /></a>
                            <?php
                        } else {
                            ?><a href="../../controlador/functions/borracar.php?<?php echo SID . "&" ?>id=<?php echo $producto_id."&bod=$producto_bodega"; ?>"><img src="../images/productoagregado.png" width="32" height="32" border="0" title="Quitar" /></a>
                            <?php
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                    <tr>
                    </tr>
                </tbody>
            </table>
            <div style="float:right;margin-right: 50px;margin-top: 20px;">
                <a class="ver_carro" href="stock_carro.php?<?php echo SID ?>">VER CARRO</a>
            </div>
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
</html>
<?php
ob_end_flush();
?>