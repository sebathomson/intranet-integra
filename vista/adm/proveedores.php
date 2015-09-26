<?php
require_once ('../../controlador/controlador_administracion_proveedores.php');

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
                <li><a href="proveedores.php?seccion=crear">CREAR</a></li>
                <li><a href="proveedores.php?seccion=buscar">BUSCAR</a></li>
                <li id="liend"><a id="cerrarsesion" class="editprofile" href="#">[Editar]</a> <a id="cerrarsesion" href="../../controlador/controlador_principal.php?accion=desconectar">[Desconectar]</a></li>
            </ul>
        </div>
        <!-- FIN MENU -->
        <div class="clear"></div>
        <!-- INICIO CONTENEDOR -->
        <div id="contenedortop">
            <img class="left" alt="" src="../images/contenedor_corner_left_top.png"/>
            <div name="titulo">
                <span id="titleseccion">ADMINISTRACI&Oacute;N - PROVEEDORES</span>
                <img class="left" alt="" src="../images/title_right.png"/>
            </div>
            <img class="right" alt="" src="../images/contenedor_corner_right_top.png"/>
        </div>
        <?php
        switch ($seccion) {
            case "ver":
                if (isset($_GET["id"])) {
                    $proveedor_rut = $_GET["id"];
                    $proveedor = Array();
                    $proveedor = $controlador_instancia_prov->proveedor_ver($proveedor_rut);

                    if ($proveedor == false) {
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
                    <table id="ver" cellspacing="0">
                        <tbody>
                            <tr>
                                <td>RUT:</td>
                                <td><?php echo $proveedor[0]; ?></td>
                            </tr>
                            <tr>
                                <td>Nombre:</td>
                                <td><?php echo $proveedor[1]; ?></td>
                            </tr>
                            <tr>
                                <td>Correo:</td>
                                <td><?php echo $proveedor[2]; ?></td>
                            </tr>
                            <tr>
                                <td>Direcci&oacute;n:</td>
                                <td><?php echo $proveedor[3]; ?></td>
                            </tr>
                            <tr>
                                <td>Fono Fijo:</td>
                                <td><?php echo $proveedor[4]; ?></td>
                            </tr>
                            <tr>
                                <td>Fono M&oacute;vil:</td>
                                <td><?php echo $proveedor[5]; ?></td>
                            </tr>
                            <tr>
                                <td>Estado:</td>
                                <td><?php echo $proveedor[6]; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- CONTENIDO FIN-->	
                    <div class="clear"></div>
                    <div class="botones">
                        <form action="proveedores.php" name="modificarproveedor" method="get">
                            <input type="hidden" name="seccion" value="modificar" />
                            <input type="hidden" name="id" value="<?php echo $proveedor[0]; ?>" />
                        </form>
                        <a class="quitar_2" href="JavaScript:history.back();">VOLVER</a>
                        <a class="agregar_2" href="javascript:document.modificarproveedor.submit()">MODIFICAR</a>
                    </div>
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
                                            <option value="proveedor_rut">RUT</option>
                                            <option value="proveedor_nombre">NOMBRE</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Estado:</td>
                                    <td>
                                        <select name="proveedor_estado">
                                            <option value="0">Desactivado</option>
                                            <option value="1" selected="selected">Activado</option>
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
                        $activacion = $_GET["proveedor_estado"];

                        $proveedor = $controlador_instancia_prov->proveedor_buscar($busqueda, $filtro, $activacion);
                        if ($proveedor == false) {
                            echo "<SCRIPT type='text/javascript'>window.onload=busquedaError;</SCRIPT>";
                        } else {
                            ?>
                            <!--INICIO RESULTADO BUSQUEDA-->
                            <table id="buscar" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>RUT</th>
                                        <th>NOMBRE</th>
                                        <th>CORREO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($x = 0; $x < count($proveedor); $x++) {
                                        $proveedor_rut = $proveedor[$x][0];
                                        $proveedor_nombre = $proveedor[$x][1];
                                        $proveedor_correo = $proveedor[$x][2];

                                        echo "<tr>";
                                        echo "<td><a id='enlace' href='proveedores.php?seccion=ver&id=$proveedor_rut'>$proveedor_rut</a></td>";
                                        echo "<td>$proveedor_nombre</td>";
                                        echo "<td>$proveedor_correo</td>";
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
                    $proveedor_rut = $_GET["id"];
                    $proveedor = Array();
                    $proveedor = $controlador_instancia_prov->proveedor_ver($proveedor_rut);

                    if ($proveedor == false) {
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
                    <form method="POST" name="modificarproveedor" action="../../controlador/controlador_administracion_proveedores.php?accion=modificar">
                        <input type="hidden" name="proveedor_rut" value="<?php echo $proveedor[0]; ?>" />
                        <table id="formularios" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td>RUT:</td>
                                    <td><?php echo $proveedor[0]; ?></td>
                                </tr>
                                <tr>
                                    <td>Nombre:</td>
                                    <td><input type="text" size="30" maxlength="30" name="proveedor_nombre" value="<?php echo $proveedor[1]; ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Correo:</td>
                                    <td><input type="text" size="50" maxlength="50" name="proveedor_correo" value="<?php echo $proveedor[2]; ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Direcci&oacute;n:</td>
                                    <td><input type="text" size="50" maxlength="50" name="proveedor_direccion" value="<?php echo $proveedor[3]; ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Fono Fijo:</td>
                                    <td><input type="text" size="15" maxlength="15" name="proveedor_fijo" value="<?php echo $proveedor[4]; ?>" /><span class="valueEjemplo">025559999</span></td>
                                </tr>
                                <tr>
                                    <td>Fono M&oacute;vil:</td>
                                    <td><input type="text" size="15" maxlength="15" name="proveedor_movil" value="<?php echo $proveedor[5]; ?>" /><span class="valueEjemplo">081234567</span></td>
                                </tr>
                                <tr>
                                    <td>Estado:</td>
                                    <td>
                                        <select name="proveedor_estado">
                                            <?php
                                            $estados = array();
                                            $estados[0] = "Desactivado";
                                            $estados[1] = "Activado";
                                            for ($contador = 0; $contador < count($estados); $contador++) {
                                                echo "<option value='$contador'";
                                                if ($proveedor[6] == $estados[$contador]) {
                                                    echo "selected='selected'";
                                                }
                                                echo ">";
                                                echo $estados[$contador];
                                                echo "</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                            </tbody>
                        </table>
                    </form>
                    <!-- CONTENIDO FIN-->	
                    <div class="botones">
                        <a class="quitar_2" href="JavaScript:history.back();">CANCELAR</a>
                        <a class="agregar_2" href="javascript:document.modificarproveedor.submit()">MODIFICAR</a>
                    </div>
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
                    <form name="crearproveedor" method="POST" action="../../controlador/controlador_administracion_proveedores.php?accion=crear">
                        <table id="formularios">
                            <tbody>
                                <tr>
                                    <td>RUT:</td>
                                    <td><input type="text" name="proveedor_rut" size="12" maxlength="12" /><span class="valueEjemplo">12345678-9</span></td>
                                </tr>
                                <tr>
                                    <td>Nombre:</td>
                                    <td><input type="text" size="30" maxlength="30" name="proveedor_nombre" /></td>
                                </tr>
                                <tr>
                                    <td>Correo:</td>
                                    <td><input type="text" size="50" maxlength="50" name="proveedor_correo" /></td>
                                </tr>
                                <tr>
                                    <td>Direcci&oacute;n:</td>
                                    <td><input type="text" size="50" maxlength="50" name="proveedor_direccion" /></td>
                                </tr>
                                <tr>
                                    <td>Fono Fijo:</td>
                                    <td><input type="text" size="15" maxlength="15" name="proveedor_fijo" /><span class="valueEjemplo">025559999</span></td>
                                </tr>
                                <tr>
                                    <td>Fono M&oacute;vil:</td>
                                    <td><input type="text" size="15" maxlength="15" name="proveedor_movil" /><span class="valueEjemplo">081234567</span></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="botones">
                            <a class="quitar_solo" href="javascript:document.crearproveedor.reset()">LIMPIAR</a>
                            <a class="agregar_solo" href="javascript:document.crearproveedor.submit()">CREAR</a>
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