<?php
require_once ('../../controlador/controlador_materiales.php');
require_once ('../../controlador/controlador_stockbodega.php');

/*CONTROLAR EL ACCESO A LAS PÁGINAS*/
$privilegios_pagina = array();
$privilegios_pagina[0] = "ADMINISTRADOR";
$privilegios_pagina[1] = "BODEGUERO";
$instancia_controlador_principal -> Validar_Acceso($privilegios_pagina);
/*CONTROLAR EL ACCESO A LAS PÁGINAS*/

$instancia_controlador_stockbodega = new controlador_stockbodega();

if (isset($_GET["material_id"])) {
    $material_id = $_GET["material_id"];

    $stock_material = array();
    $material = array();

    $stock_material = $instancia_controlador_stockbodega->ver_stock($material_id);

    $material = $instancia_controlador_materiales->material_ver($material_id);

    $material_nombre = $material[2];
} else {
    header("Location: ../bodega/materiales.php?seccion=buscar");
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
                <li id="lifirst"><a href="materiales.php?seccion=crear"><img class="left" alt="Logo" src="../images/menu_left.png" width="206px" height="45px" /></a></li>
                <li><a href="materiales.php?seccion=crear">MATERIALES</a></li>
                <li><a href="proveedores.php?seccion=crear">PROVEEDORES</a></li>
                <li id="liend"><a id="cerrarsesion" class="editprofile" href="#">[Editar]</a> <a id="cerrarsesion" href="../../controlador/controlador_principal.php?accion=desconectar">[Desconectar]</a></li>
            </ul>
        </div>
        <!-- FIN MENU -->
        <div class="clear"></div>
        <!-- INICIO CONTENEDOR -->
        <div id="contenedortop">
            <img class="left" alt="" src="../images/contenedor_corner_left_top.png"/>
            <div name="titulo">
                <span id="titleseccion">BODEGA</span>
                <img class="left" alt="" src="../images/title_right.png"/>
            </div>
            <img class="right" alt="" src="../images/contenedor_corner_right_top.png"/>
        </div>
        <div id="contenedor">
            <div class="clear"></div>
            <!-- TITULO SECCION -->
            <span id="title">STOCK</span>
            <!-- TITULO SECCION -->
            <div class="clear"></div>		
            <!-- CONTENIDO INICIO-->
            <form name="stockagregar" 
                  method="POST" 
                  action="../../controlador/controlador_stockbodega.php?accion=stockagregar" 
                  enctype="multipart/form-data">
                <input type="hidden" name="material_id" value="<?php echo $material_id; ?>" />
                <table id="formulariocrearlibre" cellspacing="0">
                    <tbody>
                        <tr>
                            <td>Nombre Material: </td>
                            <td><?php echo $material_nombre; ?></td>
                        </tr>
                    </tbody>
                </table>
                <table id="buscar" cellspacing="0">
                    <thead>
                        <tr>
                            <th>BODEGA ID</th>
                            <th>STOCK</th>
                            <th>CANTIDAD</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($contador = 0; $contador < count($stock_material); $contador++) {
                            ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $stock_material[$contador][0]; ?></td>
                                <td style="text-align: center;"><?php echo $stock_material[$contador][1]; ?></td>
                                <td style="text-align: center;"><input type="text" name="agregar_stock_<?php echo $stock_material[$contador][0]; ?>" maxlength="5" /></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div class="botones">
                    <a class="quitar_2" href="javascript:document.stockagregar.reset()">LIMPIAR</a>
                    <a class="agregar_2" href="javascript:document.stockagregar.submit()">AGREGAR</a>
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