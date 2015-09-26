<?php
require_once ('../../controlador/controlador_materiales.php');
require_once ('../../controlador/controlador_stockbodega.php');

/*CONTROLAR EL ACCESO A LAS PÁGINAS*/
$privilegios_pagina = array();
$privilegios_pagina[0] = "ADMINISTRADOR";
$privilegios_pagina[1] = "BODEGUERO";
$instancia_controlador_principal -> Validar_Acceso($privilegios_pagina);
/*CONTROLAR EL ACCESO A LAS PÁGINAS*/

if (isset($_GET["seccion"])) {
    $seccion = $_GET["seccion"];
} else {
    $seccion = "";
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
                <li id="lifirst"><a href="materiales.php?seccion=crear"><img class="left" alt="Logo" src="../images/menu_left.png" width="206px" height="45px" /></a></li>
                <li><a href="proveedores.php?seccion=crear">PROVEEDORES</a></li>
                <li><a href="materiales.php?seccion=crear">CREAR</a></li>
                <li><a href="materiales.php?seccion=buscar">BUSCAR</a></li>
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
        <?php
        switch ($seccion) {
            case "ver":
                if (isset($_GET["id"])) {
                    $material_id = $_GET["id"];
                    $material = Array();
                    $material = $instancia_controlador_materiales->material_ver($material_id);

                    if ($material == false) {
                        ?>
                        <script> 
                            location.href='?seccion=buscar&mensaje=idError'; 
                        </script>
                        <?php
                    }
                } else {
                    ?>
                    <script> 
                        location.href='?seccion=buscar&mensaje=idError'; 
                    </script>
                    <?php
                }
                ?>
                <div id="contenedor">
                    <div class="clear"></div>
                    <!-- TITULO SECCION -->
                    <span id="title">VER</span>
                    <!-- TITULO SECCION -->
                    <div class="clear"></div>	
                    <!-- CONTENIDO INICIO-->
                    <div id="descripcionproducto">
                        <img src="../images/productos-images/<?php echo $material[3] ?>" id="imagenproducto" alt="Imagen Producto" width="200px" height="200px" /> 
                        <table id="resultadostockproducto" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td id="tableheadproducto">BODEGA</td>
                                    <td id="tableheadproducto">STOCK</td>
                                </tr>
                                <?php
                                $material_stock = Array();
                                $material_stock = $instancia_controlador_stockbodega->ver_stock($material_id);
                                if ($material_stock == false) {
                                    echo "<tr>";
                                    echo "<td rowspan='2'>";
                                    echo "<center>Sin Stock</center>";
                                    echo "</td>";
                                    echo "</tr>";
                                } else {
                                    for ($contador = 0; $contador < count($material_stock); $contador++) {
                                        echo "<tr>";
                                        echo "<td>";
                                        echo $material_stock[$contador][0]; // Nombre Bodega
                                        echo "</td>";
                                        echo "<td>";
                                        echo $material_stock[$contador][1]; // Stock en esa Bodega
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        <a class="agregarmaterial" href="agregar.php?material_id=<?php echo $material_id?>">AGREGAR</a>
                    </div>
                    <div id="datosproductos">
                        <table id="ver_material" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td>ID Material:</td>
                                    <td><?php echo $material[0]; ?></td>
                                </tr>
                                <tr>
                                    <td>Nombre:</td>
                                    <td><?php echo $material[2]; ?></td>
                                </tr>
                                <tr>
                                    <td>Categoria:</td>
                                    <td><a id="enlace" href="?seccion=buscar&buscar=<?php echo $material[1]; ?>&filtro=material_categoria"><?php echo $material[1]; ?></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Proveedor:</td>
                                    <td><?php echo $material[5]; ?></td>
                                </tr>
                                <tr>
                                    <td>Descripcion:</td>
                                    <td><?php echo $material[4]; ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="clear"></div>
                        <div class="botones">
                            <form action="materiales.php" name="modificarmaterial" method="get">
                                <input type="hidden" name="id" value="<?php echo $material[0]; ?>" /> 
                                <input type="hidden" name="seccion" value="modificar" /> 
                            </form>
                            <a class="quitar_2" href="JavaScript:history.back();">VOLVER</a>
                            <a class="agregar_2" href="javascript:document.modificarmaterial.submit()">MODIFICAR</a>
                        </div>
                    </div>
                    <!-- CONTENIDO FIN-->	
                    <div class="clear"></div>
                </div>
                <?php
                break;
            case "buscar":
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
//                        $activacion = $_GET["activacion"];
                        $material = $instancia_controlador_materiales->material_buscar($busqueda, $filtro);
                        if ($material == false) {
                            echo "<SCRIPT type='text/javascript'>window.onload=busquedaError;</SCRIPT>";
                        } else {
                            ?>
                            <!--INICIO RESULTADO BUSQUEDA-->
                            <table id="buscar" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="20px" >ID</th>
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
                                        $material_categoria = $material[$x][2];
                                        $material_bodega = $material[$x][3];
                                        $material_stock = $material[$x][4];

                                        echo "<tr>";
                                        echo "<td><a id='enlace' href='materiales.php?seccion=ver&id=$material_id'>$material_id</a></td>";
                                        echo "<td>$material_nombre</td>";
                                        echo "<td>$material_categoria</td>";
                                        echo "<td>$material_bodega</td>";
                                        echo "<td>$material_stock</td>";
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
                <?php
                break;
            case "modificar":
                if (isset($_GET["id"])) {
                    $material_id = $_GET["id"];
                    $material = Array();
                    $material = $instancia_controlador_materiales->material_ver($material_id);

                    if ($material == false) {
                        ?>
                        <script> 
                            location.href='?seccion=buscar&mensaje=idError'; 
                        </script>
                        <?php
                    }
                } else {
                    ?>
                    <script> 
                        location.href='?seccion=buscar&mensaje=idError'; 
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
                    <div id="descripcionproducto">
                        <img src="../images/productos-images/<?php echo $material[3] ?>" id="imagenproducto" alt="Imagen Producto" width="200px" height="200px" /> 
                    </div>
                    <div id="datosproductos">
                        <form name="modificarmaterial" 
                              method="POST" 
                              action="../../controlador/controlador_materiales.php?accion=modificar" 
                              enctype="multipart/form-data">
                            <input type="hidden" name="material_id" value="<?php echo $material[0]; ?>" />
                            <table id="formularios" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td>ID Material:</td>
                                        <td><?php echo $material[0]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Nombre:</td>
                                        <td><?php echo $material[2]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Categor&iacute;a:</td>
                                        <td>
                                            <select name="material_categoria">
                                                <?php
                                                $categoria = array();
                                                $categoria = $instancia_controlador_materiales->getCategoria();
                                                for ($contador = 0; $contador < count($categoria); $contador++) {
                                                    $material_id = $categoria[$contador][0];
                                                    echo "<option disabled='disabled' value='$material_id'>";
                                                    echo $categoria[$contador][1];
                                                    echo "</option>";

                                                    /*      */

                                                    $subcategoria = array();
                                                    $subcategoria = $categoria[$contador][2];

                                                    for ($contador2 = 0; $contador2 < count($subcategoria); $contador2++) {
                                                        $subcategoria_id = $subcategoria[$contador2][0];

                                                        if ($material[1] == $subcategoria[$contador2][1]) {
                                                            echo "<option selected='selected' value='$subcategoria_id'>&nbsp;&nbsp;&nbsp;";
                                                        } else {
                                                            echo "<option value='$subcategoria_id'>&nbsp;&nbsp;&nbsp;";
                                                        }
                                                        echo $subcategoria[$contador2][1];
                                                        echo "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Proveedor:</td>
                                        <td><?php echo $material[5]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Descripci&oacute;n</td>
                                        <td><textarea name="material_descripcion" maxlength="50"><?php echo $material[4]; ?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td>Imagen del Material:</td>
                                        <td>
                                            <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
                                            <input type="file" name="imagen" id="imagen" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                        <div class="botones">
                            <a class="quitar_2" href="JavaScript:history.back();">CANCELAR</a>
                            <a class="agregar_2" href="javascript:document.modificarmaterial.submit()">MODIFICAR</a>
                        </div>
                    </div>
                    <!-- CONTENIDO FIN-->	

                    <div class="clear"></div>
                </div>
                <?php
                break;
            default:
                ?>
                <div id="contenedor">
                    <div class="clear"></div>
                    <!-- TITULO SECCION -->
                    <span id="title">NUEVO</span>
                    <!-- TITULO SECCION -->
                    <div class="clear"></div>		
                    <!-- CONTENIDO INICIO-->
                    <form name="crearmaterial" 
                          method="POST" 
                          action="../../controlador/controlador_materiales.php?accion=crearmaterial" 
                          enctype="multipart/form-data">
                        <table id="formularios">
                            <tbody>
                                <tr>
                                    <td>Nombre</td>
                                    <td><input type="text" name="material_nombre" maxlength="30" /></td>
                                </tr>
                                <tr>
                                    <td>Descripci&oacute;n</td>
                                    <td><textarea name="material_descripcion" maxlength="50"></textarea></td>
                                </tr>
                                <?php
                                $proveedores = array();
                                $proveedores = $controlador_instancia_prov->proveedores_activos();
                                ?>
                                <tr>
                                    <td>Proveedor:</td>
                                    <td>
                                        <select name="material_proveedor">
                                            <option value="no_option">Seleccione un Proveedor</option>
                                            <?php
                                            if (count($proveedores) == 0) {
                                                echo "<option value='no-cliente'>";
                                                echo "Sin Clientes";
                                                echo "</option>";
                                            } else {
                                                for ($i = 0; $i < count($proveedores); $i++) {
                                                    $rut_cliente = $proveedores[$i][0];
                                                    $nombre_cliente = $proveedores[$i][1];

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
                                    <td>Categor&iacute;a:</td>
                                    <td>
                                        <select name="material_categoria">
                                            <option value="no_option">Seleccione una Categor&iacute;a</option>
                                            <?php
                                            $categoria = array();
                                            $categoria = $instancia_controlador_materiales->getCategoria();
                                            for ($contador = 0; $contador < count($categoria); $contador++) {
                                                $material_id = $categoria[$contador][0];
                                                echo "<option disabled='disabled' value='$material_id'>";
                                                echo $categoria[$contador][1];
                                                echo "</option>";

                                                /*      */

                                                $subcategoria = array();
                                                $subcategoria = $categoria[$contador][2];

                                                for ($contador2 = 0; $contador2 < count($subcategoria); $contador2++) {
                                                    $subcategoria_id = $subcategoria[$contador2][0];
                                                    echo "<option value='$subcategoria_id'>&nbsp;&nbsp;&nbsp;";
                                                    echo $subcategoria[$contador2][1];
                                                    echo "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Imagen del Material:</td>
                                    <td>
                                        <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
                                        <input type="file" name="imagen" id="imagen" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="botones">
                            <a class="quitar_solo" href="javascript:document.crearmaterial.reset()">LIMPIAR</a>
                            <a class="agregar_solo" href="javascript:document.crearmaterial.submit()">CREAR</a>
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