<?php
require_once ('../../controlador/controlador_materiales.php');

/*CONTROLAR EL ACCESO A LAS PÁGINAS*/
$privilegios_pagina = array();
$privilegios_pagina[0] = "ADMINISTRADOR";
$privilegios_pagina[1] = "VENDEDOR";
$privilegios_pagina[2] = "BODEGUERO";
$privilegios_pagina[3] = "NORMAL";
$instancia_controlador_principal -> Validar_Acceso($privilegios_pagina);
/*CONTROLAR EL ACCESO A LAS PÁGINAS*/

if (isset($_GET["buscar"])) {
    $busqueda = $_GET["buscar"];
} else {
    $busqueda = "";
}
if (isset($_GET["filtro"])) {
    $filtro = $_GET["filtro"];
} else {
    $filtro = "material_nombre";
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
                <li><a href="?seccion=buscar">BUSCAR</a></li>
                <li id="liend"><a id="cerrarsesion" class="editprofile" href="#">[Editar]</a> <a id="cerrarsesion" href="../../controlador/controlador_principal.php?accion=desconectar">[Desconectar]</a></li>
            </ul>
        </div>
        <!-- FIN MENU -->
        <div class="clear"></div>
        <!-- INICIO CONTENEDOR -->
        <div id="contenedortop">
            <img class="left" alt="" src="../images/contenedor_corner_left_top.png"/>
            <div name="titulo">
                <span id="titleseccion">STOCK</span>
                <img class="left" alt="" src="../images/title_right.png"/>
            </div>
            <img class="right" alt="" src="../images/contenedor_corner_right_top.png"/>
        </div>
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
                            <td>Buscar:</td>
                            <td><input type="text" name="buscar" /></td>
                        </tr>
                        <tr>
                            <td>Filtro:</td>
                            <td>
                                <select name="filtro">
                                    <option value="material_nombre">NOMBRE</option>
                                    <option value="material_id">ID</option>
                                    <option value="material_categoria">CATEGOR&Iacute;A</option>
                                    <option value="material_bodega">BODEGA</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="botones">
                    <a class="agregar_solo" href="javascript:document.buscar.submit()">BUSCAR</a>
                </div>
            </form>
            <!-- FIN BUSCAR -->
            <?php
            if (isset($_GET["buscar"]) AND isset($_GET["filtro"])) {
                $busqueda = $_GET["buscar"];
                $filtro = $_GET["filtro"];

                $material = array();

                $material = $instancia_controlador_materiales->material_buscar($busqueda, $filtro);

                if ($material == false) {
                    echo "<SCRIPT type='text/javascript'>window.onload=busquedaError;</SCRIPT>";
                } else {
                    ?>
                    <!--INICIO RESULTADO BUSQUEDA-->
                    <table id="buscar" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NOMBRE</th>
                                <th>CATEGOR&Iacute;A</th>
                                <th>BODEGA</th>
                                <th>STOCK</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($x = 0; $x < count($material); $x++) {
                                $material_id = $material[$x][0];
                                $material_nombre = $material[$x][1];
                                $material_cat = $material[$x][2];
                                $material_bodega = $material[$x][3];
                                $material_stock = $material[$x][4];

                                echo "<tr>";
                                echo "<td>$material_id</td>";
                                echo "<td>$material_nombre</td>";
                                echo "<td>$material_cat</td>";
                                echo "<td>$material_bodega</td>";
                                echo "<td>$material_stock</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>                
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