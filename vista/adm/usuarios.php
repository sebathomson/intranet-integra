<?php
require_once('../../controlador/controlador_administracion_usuarios.php');

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
                <li><a href="usuarios.php?seccion=crear">CREAR</a></li>
                <li><a href="usuarios.php?seccion=buscar">BUSCAR</a></li>
                <li id="liend"><a id="cerrarsesion" class="editprofile" href="#">[Editar]</a> <a id="cerrarsesion" href="../../controlador/controlador_principal.php?accion=desconectar">[Desconectar]</a></li>
            </ul>
        </div>
        <!-- FIN MENU -->
        <div class="clear"></div>
        <!-- INICIO CONTENEDOR -->
        <div id="contenedortop">
            <img class="left" alt="" src="../images/contenedor_corner_left_top.png"/>
            <div name="titulo">
                <span id="titleseccion">ADMINISTRACI&Oacute;N - USUARIO</span>
                <img class="left" alt="" src="../images/title_right.png"/>
            </div>
            <img class="right" alt="" src="../images/contenedor_corner_right_top.png"/>
        </div>
        <?php
        switch ($seccion) {
            case "ver":
                if (isset($_GET["id"])) {
                    $usuario_rut = $_GET["id"];
                    $usuario = Array();
                    $usuario = $instancia_controlador_usuario -> usuario_ver($usuario_rut);

                    if ($usuario == false) {
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
                                <td><?php echo $usuario[0]; ?></td>
                            </tr>
                            <tr>
                                <td>UserName:</td>
                                <td><?php echo $usuario[1]; ?></td>
                            </tr>
                            <tr>
                                <td>Tipo Usuario:</td>
                                <td><?php echo $usuario[3]; ?></td>
                            </tr>
                            <tr>
                                <td>Estado:</td>
                                <td><?php echo $usuario[4]; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- CONTENIDO FIN-->	
                    <div class="clear"></div>
                    <div class="botones">
                        <form action="usuarios.php" name="modificarusuario" method="get">
                            <input type="hidden" name="id" value="<?php echo $usuario[0]; ?>" /> 
                            <input type="hidden" name="seccion" value="modificar" /> 
                        </form>
                        <a class="quitar_2" href="JavaScript:history.back();">VOLVER</a>
                        <a class="agregar_2" href="javascript:document.modificarusuario.submit()">MODIFICAR</a>
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
                                            <option value="usuario_rut">RUT</option>
                                            <option value="usuario_nombre">NOMBRE</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Estado:</td>
                                    <td>
                                        <select name="usuario_estado">
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
                        $activacion = $_GET["usuario_estado"];
                        
                        $usuario = $instancia_controlador_usuario -> usuario_buscar($busqueda, $filtro, $activacion);
                        if ($usuario == false) {
                            echo "<SCRIPT type='text/javascript'>window.onload=busquedaError;</SCRIPT>";
                        } else {
                            ?>
                            <!--INICIO RESULTADO BUSQUEDA-->
                            <table id="buscar" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>RUT</th>
                                        <th>NOMBRE</th>
                                        <th>TIPO USUARIO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($x = 0; $x < count($usuario); $x++) {
                                        $usuario_rut = $usuario[$x][0];
                                        $usuario_nombre = $usuario[$x][1];
                                        $usuario_correo = $usuario[$x][3];

                                        echo "<tr>";
                                        echo "<td><a id='enlace' href='usuarios.php?seccion=ver&id=$usuario_rut'>$usuario_rut</a></td>";
                                        echo "<td>$usuario_nombre</td>";
                                        echo "<td>$usuario_correo</td>";
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
                    $usuario_rut = $_GET["id"];
                    $usuario = Array();
                    $usuario = $instancia_controlador_usuario -> usuario_ver($usuario_rut);

                    if ($usuario == false) {
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
                    <form method="POST" name="modificarusuario" action="../../controlador/controlador_administracion_usuarios.php?accion=modificar">
                        <input type="hidden" name="usuario_nombre" value="<?php echo $usuario[1]; ?>" />
                        <input type="hidden" name="usuario_rut" value="<?php echo $usuario[0]; ?>" />
                        <table id="formularios" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td>RUT:</td>
                                    <td><?php echo $usuario[0]; ?></td>
                                </tr>
                                <tr>
                                    <td>UserName:</td>
                                    <td><?php echo $usuario[1]; ?></td>
                                </tr>
                                <tr>
                                    <td>Password Nuevo:</td>
                                    <td><input type="text" name="usuario_new_pass" maxlength="20" value="" /></td>
                                </tr>
                                <tr>
                                    <td>Tipo Usuario:</td>
                                    <td>
                                        <select name="usuario_tipo">
                                            <?php
                                            $tipos_usuario = array();
                                            $tipos_usuario = $instancia_controlador_usuario -> getTiposUsuarios();
                                            for ($contador = 0; $contador < count($tipos_usuario); $contador++) {
                                                echo "<option value='$tipos_usuario[$contador]'";
                                                if ($usuario[3] == $tipos_usuario[$contador]) {
                                                    echo "selected='selected'";
                                                }
                                                echo ">";
                                                echo $tipos_usuario[$contador];
                                                echo "</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Estado:</td>
                                    <td>
                                        <select name="usuario_estado">
                                            <?php
                                            $estados = array();
                                            $estados[0] = "Desactivado";
                                            $estados[1] = "Activado";
                                            for ($contador = 0; $contador < count($estados); $contador++) {
                                                echo "<option value='$contador'";
                                                if ($usuario[4] == $estados[$contador]) {
                                                    echo "selected='selected'";
                                                }
                                                echo ">";
                                                echo $estados[$contador];
                                                echo "</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                    <!-- CONTENIDO FIN-->	
                    <div class="botones">
                        <a class="quitar_2" href="JavaScript:history.back();">CANCELAR</a>
                        <a class="agregar_2" href="javascript:document.modificarusuario.submit()">MODIFICAR</a>
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
                    <form name="crearusuario" method="POST" action="../../controlador/controlador_administracion_usuarios.php?accion=crear">
                        <table id="formularios">
                            <tbody>
                                <tr>
                                    <td>RUT:</td>
                                    <td>
                                        <select name="usuario_rut_empleado">
                                            <option value="no_option">Seleccione un RUT</option>
                                            <?php
                                            $rut_empelados_disponibles = array();
                                            $rut_empelados_disponibles = $instancia_controlador_usuario -> getEmpleadosSinUser();
                                            for ($contador = 0; $contador < count($rut_empelados_disponibles); $contador++) {
                                                echo "<option value='$rut_empelados_disponibles[$contador]'>";
                                                echo $rut_empelados_disponibles[$contador];
                                                echo "</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>UserName:</td>
                                    <td><input type="text" name="usuario_nombre" maxlength="50" /></td>
                                </tr>
                                <tr>
                                    <td>Tipo Usuario:</td>
                                    <td>
                                        <select name="usuario_tipo">
                                            <option value="no_option">Seleccione un Tipo de Usuario</option>
                                            <?php
                                            $tipos_usuario = array();
                                            $tipos_usuario = $instancia_controlador_usuario -> getTiposUsuarios();
                                            for ($contador = 0; $contador < count($tipos_usuario); $contador++) {
                                                echo "<option value='$tipos_usuario[$contador]'>";
                                                echo $tipos_usuario[$contador];
                                                echo "</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="botones">
                            <a class="quitar_solo" href="javascript:document.crearusuario.reset()">LIMPIAR</a>
                            <a class="agregar_solo" href="javascript:document.crearusuario.submit()">CREAR</a>
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