<?php
require_once ("../../controlador/controlador_stockbodega.php");

/*CONTROLAR EL ACCESO A LAS PÁGINAS*/
$privilegios_pagina = array();
$privilegios_pagina[0] = "ADMINISTRADOR";
$privilegios_pagina[1] = "VENDEDOR";
$instancia_controlador_principal -> Validar_Acceso($privilegios_pagina);
/*CONTROLAR EL ACCESO A LAS PÁGINAS*/

//session_start();
error_reporting(E_ALL);
@ini_set('display_errors', '1');

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
                <li id="liend"><a id="cerrarsesion" class="editprofile" href="#">[Editar]</a> <a id="cerrarsesion" href="../../controlador/controlador_principal.php?accion=desconectar">[Desconectar]</a></li>
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
            <div style="margin-bottom: 20px;">
                <?php
                if ($venta_cabecera[3] == "insumos") {
                    ?> 
                    <div style="float:right;margin-right: 50px;">
                        <a class="quitar_solo" href="<?php echo $venta_cabecera[3]; ?>.php?recordarvta=cerrar">CANCELAR</a>
                    </div>                    
                    <?php
                } else {
                    $link = "../obra/obras.php?id=$venta_cabecera[0]&seccion=modificar&recordarvta=cerrar";
                    ?> 
                    <div style="float:right;margin-right: 50px;">
                        <a class="quitar_solo" href="<?php echo $link; ?>">CANCELAR</a>
                    </div>                    
                    <?php
                }
                ?>
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
                            <td>Nombre Cliente:</td>
                            <td><?php echo $venta_cabecera[1]; ?></td>
                        </tr>
                    </table>
                    <?php
                }
                ?>              
            </div>
            <input type="hidden" name="venta_tipo" value="<?php echo $venta_cabecera[3]; ?>" />
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
                            <th>STOCK</th>
                            <th>CANTIDAD</th>
                            <th width="70px">BORRAR</th>
                            <th width="70px">ACTUALIZAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($carro as $k => $v) {
                            ?>
                            <form name="a<?php echo $v['identificador'] ?>" method="post" action="../../controlador/functions/agregacar.php?<?php echo SID. "&id = a". $v['id']."&bod=".$v['bodega']?>"> 
                                <input type="hidden" name="sector" value="carro"/>
                                <tr> 
                                    <td><?php echo $v['materialID'] ?></td>
                                    <td><?php echo $v['material'] ?></td>
                                    <td><?php echo $v['bodega'] ?></td>
                                    <td><?php echo $v['stock'] ?></td>
                                    <td> 
                                        <input name="cantidad" type="text" id="cantidad" value="<?php echo $v['cantidad'] ?>" size="8" />
                                        <input name="id" type="hidden" id="id" value="<?php echo $v['id'] ?>" />
                                    </td>
                                    <td>
                                        <?php
                                        $link = "../../controlador/functions/borracar.php?" . SID . "&id=" . $v['id'] . "&bod=" . $v['bodega'];
                                        ?>
                                        <center>
                                            <a href="<?php echo $link ?>"><img src="../images/trash.png" width="32" height="32" border="0" /></a>
                                        </center>
                                    </td>
                                    <td> 
                                        <center>
                                            <input name="imageField" type="image" src="../images/actualizar.png" width="22" height="22" border="0" />
                                        </center>
                                    </td>
                                </tr>
                            </form>                            
                        <?php } ?>
                        <tr>
                        </tr>
                    </tbody>
                </table>
                <div class="botones">
                    <a class="quitar_2" href="stock.php?<?php echo SID ?>">AGREGAR</a>
                    <a class="agregar_2" href="egreso.php?<?php echo SID ?>">CONFIRMAR</a>
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