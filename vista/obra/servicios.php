<?php
require_once("../../controlador/controlador_obras.php");
require_once("../../controlador/controlador_ventas.php");

/*CONTROLAR EL ACCESO A LAS PÁGINAS*/
$privilegios_pagina = array();
$privilegios_pagina[0] = "ADMINISTRADOR";
$instancia_controlador_principal -> Validar_Acceso($privilegios_pagina);
/*CONTROLAR EL ACCESO A LAS PÁGINAS*/

if (isset($_GET["seccion"])) {
    $seccion = $_GET["seccion"];
} else {
    $seccion = "crear";
}

$clientes = array();

$clientes = $instancia_controlador_clientes->clientes_activos();
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
                <li><a href="../venta/insumos.php">VENTA INSUMOS</a></li>
                <li><a href="../venta/servicios.php">CREAR</a></li>
                <li><a href="?seccion=buscar">BUSCAR</a></li>
                <li><a href="obras.php">HOME OBRAS</a></li>
                <li id="liend"><a id="cerrarsesion" class="editprofile" href="#">[Editar]</a> <a id="cerrarsesion" href="../../controlador/controlador_principal.php?accion=desconectar">[Desconectar]</a></li>
            </ul>
        </div>
        <!-- FIN MENU -->
        <div class="clear"></div>
        <!-- INICIO CONTENEDOR -->
        <div id="contenedortop">
            <img class="left" alt="" src="../images/contenedor_corner_left_top.png"/>
            <div name="titulo">
                <span id="titleseccion">SERVICIOS</span>
                <img class="left" alt="" src="../images/title_right.png"/>
            </div>
            <img class="right" alt="" src="../images/contenedor_corner_right_top.png"/>
        </div>
        <?php
        switch ($seccion) {
            case "ver":
                if (isset($_GET["id"])) {
                    $servicio_id = $_GET["id"];
                } else {
                    ?>
                    <script> 
                        location.href='?seccion=crear'; 
                    </script>
                    <?php
                }
                $servicio = array();
                $servicio = $instancia_controlador_obras->servicio_ver($servicio_id);

                if ($servicio == false) {
                    ?>
                    <script> 
                        location.href='?seccion=crear'; 
                    </script>
                    <?php
                }
                $servicio_nombre = $servicio[0][1];
                $servicio_descripcion = $servicio[0][2];
                $servicio_cliente = $servicio[0][3];
                $servicio_fecha = $servicio[0][4];
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
                                <td>ID servicio:</td>
                                <td><?php echo $servicio_id; ?></td>
                            </tr>
                            <tr>
                                <td>Nombre servicio:</td>
                                <td><?php echo $servicio_nombre; ?></td>
                            </tr>
                            <tr>
                                <td>Descripci&oacute;n servicio:</td>
                                <td><?php echo $servicio_descripcion; ?></td>
                            </tr>
                            <tr>
                                <td>Cliente:</td>
                                <td><?php echo $servicio_cliente; ?></td>
                            </tr>
                            <tr>
                                <td>Fecha:</td>
                                <td><?php echo $servicio_fecha; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- CONTENIDO FIN-->	
                    <div class="clear"></div>
                    <div class="botones" style="margin-bottom: 50px">
                        <form action="servicios.php" name="modificarservicio" method="get">
                            <input type="hidden" name="id" value="<?php echo $servicio_id; ?>" /> 
                            <input type="hidden" name="seccion" value="modificar" /> 
                        </form>
                        <a class="quitar_2" href="JavaScript:history.back();">VOLVER</a>
                        <a class="agregar_2" href="javascript:document.modificarservicio.submit()">MODIFICAR</a>
                    </div>
                    <div class="clear"></div>
                    <!-- TITULO SECCION -->
                    <span id="title">OBRAS</span>
                    <!-- TITULO SECCION -->
                    <div class="clear"></div>	
                    <!-- INICIO OBRAS -->
                    <?php
                    $obras = array();

                    $obras = $instancia_controlador_obras->obra_buscar($servicio_id, "servicio_id");

                    if ($obras == false) {
                        ?>
                        <center>
                            <div id="error">Servicio sin obras</div>
                        </center>
                        <?php
                    } else {
                        ?>
                        <table id="buscar" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>NOMBRE</th>
                                    <th>ESTADO</th>
                                </tr>
                            </thead>
                            <tbody>                            
                                <?php
                                for ($contador_obras = 0; $contador_obras < count($obras); $contador_obras++) {
                                    $obra_id = $obras[$contador_obras][0];
                                    $obra_nombre = $obras[$contador_obras][2];
                                    $obra_estado = $obras[$contador_obras][3];

                                    echo "<tr>";
                                    echo "<td><a id='enlace' href='obras.php?seccion=ver&id=$obra_id'>$obra_id</a></td>";
                                    echo "<td>$obra_nombre</td>";
                                    echo "<td>$obra_estado</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                    }
                    ?>
                    <!-- FIN OBRAS -->
                    <div class="botones" style="margin-bottom: 50px">
                        <form action="obras.php" name="crearobra" method="get">
                            <input type="hidden" name="servicio_id" value="<?php echo $servicio_id; ?>" /> 
                        </form>
                        <a class="agregar_solo" href="javascript:document.crearobra.submit()">AGREGAR</a>
                    </div>
                </div>
                <?php
                break;
            case "buscar":
                if (isset($_GET["buscar"])) {
                    $busqueda = $_GET["buscar"];
                } else {
                    $busqueda = "";
                }
                if (isset($_GET["filtro"])) {
                    $filtro = $_GET["filtro"];
                } else {
                    $filtro = "servicio_id";
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
                                    <td>Buscar:</td>
                                    <td><input type="text" name="buscar" /></td>
                                </tr>
                                <tr>
                                    <td>Filtro:</td>
                                    <td>
                                        <select name="filtro">
                                            <option value="servicio_id">ID</option>
                                            <option value="servicio_nombre">NOMBRE</option>
                                            <option value="servicio_cliente">CLIENTE</option>
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
                        $servicio = array();
                        $servicio = $instancia_controlador_obras->servicio_buscar($busqueda, $filtro);
                        if ($servicio == false) {
                            echo "<SCRIPT type='text/javascript'>window.onload=busquedaError;</SCRIPT>";
                        } else {
                            ?>
                            <!--INICIO RESULTADO BUSQUEDA-->
                            <table id="buscar" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NOMBRE</th>
                                        <th>CLIENTE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($x = 0; $x < count($servicio); $x++) {
                                        $servicio_id = $servicio[$x][0];
                                        $servicio_nombre = $servicio[$x][1];
                                        $servicio_cliente = $servicio[$x][3];

                                        echo "<tr>";
                                        echo "<td><a id='enlace' href='servicios.php?seccion=ver&id=$servicio_id'>$servicio_id</a></td>";
                                        echo "<td>$servicio_nombre</td>";
                                        echo "<td>$servicio_cliente</td>";
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
                    $servicio_id = $_GET["id"];
                } else {
                    $servicio_id = "00";
                }
                $servicio = array();
                $servicio = $instancia_controlador_obras->servicio_ver($servicio_id);

                if ($servicio == false) {
                    ?>
                    <script> 
                        location.href='?seccion=crear'; 
                    </script>
                    <?php
                }

                $servicio_nombre = $servicio[0][1];
                $servicio_descripcion = $servicio[0][2];
                $servicio_cliente = $servicio[0][3];
                $servicio_fecha = $servicio[0][4];
                ?>
                <div id="contenedor">
                    <div class="clear"></div>
                    <!-- TITULO SECCION -->
                    <span id="title">MODIFICAR</span>
                    <!-- TITULO SECCION -->
                    <div class="clear"></div>	
                    <!-- CONTENIDO INICIO-->
                    <form name="modificarservicio" method="POST" action="../../controlador/controlador_obras.php?obraccion=servicio_modificar">
                        <input type="hidden" name="servicio_id" value="<?php echo $servicio_id; ?>" />
                        <table id="formularios" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td>ID servicio:</td>
                                    <td><?php echo $servicio_id; ?></td>
                                </tr>
                                <tr>
                                    <td>Nombre servicio:</td>
                                    <td><input name="servicio_nombre" value="<?php echo $servicio_nombre; ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Descripci&oacute;n servicio:</td>
                                    <td><textarea name="servicio_descripcion"><?php echo $servicio_descripcion; ?></textarea></td>
                                </tr>
                                <tr>
                                    <td>Cliente:</td>
                                    <td><?php echo $servicio_cliente; ?></td>
                                </tr>
                                <tr>
                                    <td>Fecha:</td>
                                    <td><?php echo $servicio_fecha; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                    <!-- CONTENIDO FIN-->	
                    <div class="botones">
                        <a class="quitar_2" href="JavaScript:history.back();">CANCELAR</a>
                        <a class="agregar_2" href="javascript:document.modificarservicio.submit()">MODIFICAR</a>
                    </div>
                    <div class="clear"></div>
                </div>
                <?php
                break;
            default:
                ?>
                <script> 
                    location.href='../venta/servicios.php'; 
                </script>
            <?php
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
