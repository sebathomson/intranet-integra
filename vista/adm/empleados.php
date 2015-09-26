<?php
require_once('../../controlador/controlador_administracion_empleados.php');

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
                <li><a href="empleados.php?seccion=crear">CREAR</a></li>
                <li><a href="empleados.php?seccion=buscar">BUSCAR</a></li>
                <li id="liend"><a id="cerrarsesion" class="editprofile" href="#">[Editar]</a> <a id="cerrarsesion" href="../../controlador/controlador_principal.php?accion=desconectar">[Desconectar]</a></li>
            </ul>
        </div>
        <!-- FIN MENU -->
        <div class="clear"></div>
        <!-- INICIO CONTENEDOR -->
        <div id="contenedortop">
            <img class="left" alt="" src="../images/contenedor_corner_left_top.png"/>
            <div name="titulo">
                <span id="titleseccion">ADMINISTRACI&Oacute;N - EMPLEADOS</span>
                <img class="left" alt="" src="../images/title_right.png"/>
            </div>
            <img class="right" alt="" src="../images/contenedor_corner_right_top.png"/>
        </div>
        <?php
        switch ($seccion) {
            case "ver":
                if (isset($_GET["id"])) {
                    $empleado_rut = $_GET["id"];
                    $empleado = Array();
                    $empleado = $instancia_controlador_empleados->empleados_ver($empleado_rut);

                    if ($empleado == false) {
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
                                <td><?php echo $empleado[0]; ?></td>
                            </tr>
                            <tr>
                                <td>Nombre:</td>
                                <td><?php echo $empleado[1]; ?></td>
                            </tr>
                            <tr>
                                <td>Apellido Pat:</td>
                                <td><?php echo $empleado[2]; ?></td>
                            </tr>
                            <tr>
                                <td>Apellido Mat:</td>
                                <td><?php echo $empleado[3]; ?></td>
                            </tr>
                            <tr>
                                <td>Correo:</td>
                                <td><?php echo $empleado[4]; ?></td>
                            </tr>
                            <tr>
                                <td>Direcci&oacute;n:</td>
                                <td><?php echo $empleado[5]; ?></td>
                            </tr>
                            <tr>
                                <td>Fono Fijo:</td>
                                <td><?php echo $empleado[6]; ?></td>
                            </tr>
                            <tr>
                                <td>Fono M&oacute;vil:</td>
                                <td><?php echo $empleado[7]; ?></td>
                            </tr>
                            <tr>
                                <td>Tipo Empleado:</td>
                                <td><?php echo $empleado[8]; ?></td>
                            </tr>
                            <tr>
                                <td>Estado:</td>
                                <td><?php echo $empleado[9]; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- CONTENIDO FIN-->	
                    <div class="clear"></div>
                    <div class="botones">
                        <form action="empleados.php" name="modificarempleado" method="get">
                            <input type="hidden" name="id" value="<?php echo $empleado[0]; ?>" /> 
                            <input type="hidden" name="seccion" value="modificar" /> 
                        </form>
                        <a class="quitar_2" href="JavaScript:history.back();">VOLVER</a>
                        <a class="agregar_2" href="javascript:document.modificarempleado.submit()">MODIFICAR</a>
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
                                            <option value="empleado_rut">RUT</option>
                                            <option value="empleado_nombre">NOMBRE</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Estado:</td>
                                    <td>
                                        <select name="activacion">
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
                        $activacion = $_GET["activacion"];
                        $empleado = $instancia_controlador_empleados->empleados_buscar($busqueda, $filtro,$activacion);
                        if ($empleado == false) {
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
                                    for ($x = 0; $x < count($empleado); $x++) {
                                        $empleado_rut = $empleado[$x][0];
                                        $empleado_nombre = $empleado[$x][1];
                                        $empleado_correo = $empleado[$x][4];

                                        echo "<tr>";
                                        echo "<td><a id='enlace' href='empleados.php?seccion=ver&id=$empleado_rut'>$empleado_rut</a></td>";
                                        echo "<td>$empleado_nombre</td>";
                                        echo "<td>$empleado_correo</td>";
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
                    $empleado_rut = $_GET["id"];
                    $empleado = Array();
                    $empleado = $instancia_controlador_empleados->empleados_ver($empleado_rut);

                    if ($empleado == false) {
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
                    <form method="POST" name="modificarempleado" action="../../controlador/controlador_administracion_empleados.php?accion=modificar">
                        <input type="hidden" name="empleado_rut" value="<?php echo $empleado[0]; ?>" />
                        <table id="formularios" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td>RUT:</td>
                                    <td><?php echo $empleado[0]; ?></td>
                                </tr>
                                <tr>
                                    <td>Nombre:</td>
                                    <td><input type="text" name="empleado_nombre" maxlength="30" value="<?php echo $empleado[1]; ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Apellido Pat:</td>
                                    <td><input type="text" name="empleado_ap" maxlength="40" value="<?php echo $empleado[2]; ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Apellido Mat:</td>
                                    <td><input type="text" name="empleado_am" maxlength="40" value="<?php echo $empleado[3]; ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Correo:</td>
                                    <td><input type="text" name="empleado_correo" maxlength="50" value="<?php echo $empleado[4]; ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Direcci&oacute;n:</td>
                                    <td><input type="text" name="empleado_direccion" maxlength="50" value="<?php echo $empleado[5]; ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Fono Fijo:</td>
                                    <td><input type="text" name="empleado_fijo" maxlength="15" value="<?php echo $empleado[6]; ?>" /><span class="valueEjemplo">025559999</span></td>
                                </tr>
                                <tr>
                                    <td>Fono M&oacute;vil:</td>
                                    <td><input type="text" name="empleado_movil" maxlength="15" value="<?php echo $empleado[7]; ?>" /><span class="valueEjemplo">081234567</span></td>
                                </tr>
                                <tr>
                                    <td>Tipo empleado:</td>
                                    <td>
                                        <select name="empleado_tipo">
                                            <?php
                                            $tipos_empleado = array();
                                            $tipos_empleado = $instancia_controlador_empleados->getTiposEmpleados();
                                            for ($contador = 0; $contador < count($tipos_empleado); $contador++) {
                                                echo "<option value='$tipos_empleado[$contador]'";
                                                if ($empleado[8] == $tipos_empleado[$contador]) {
                                                    echo "selected='selected'";
                                                }
                                                echo ">";
                                                echo $tipos_empleado[$contador];
                                                echo "</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Estado:</td>
                                    <td>
                                        <select name="empleado_estado">
                                            <?php
                                            $tipos_empleado = array();
                                            $tipos_empleado[0] = "Desactivado";
                                            $tipos_empleado[1] = "Activado";
                                            for ($contador = 0; $contador < count($tipos_empleado); $contador++) {
                                                echo "<option value='$contador'";
                                                if ($empleado[9] == $tipos_empleado[$contador]) {
                                                    echo "selected='selected'";
                                                }
                                                echo ">";
                                                echo $tipos_empleado[$contador];
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
                        <a class="agregar_2" href="javascript:document.modificarempleado.submit()">MODIFICAR</a>
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
                    <form name="crearempleado" method="POST" action="../../controlador/controlador_administracion_empleados.php?accion=crear">
                        <table id="formularios">
                            <tbody>
                                <tr>
                                    <td>RUT:</td>
                                    <td><input type="text" name="empleado_rut" size="12" maxlength="12" /><span class="valueEjemplo">12345678-9</span></td>
                                </tr>
                                <tr>
                                    <td>Nombre:</td>
                                    <td><input type="text" name="empleado_nombre" maxlength="30" /></td>
                                </tr>
                                <tr>
                                    <td>Apellido Pat:</td>
                                    <td><input type="text" name="empleado_ap" maxlength="40" /></td>
                                </tr>
                                <tr>
                                    <td>Aapellido Mat:</td>
                                    <td><input type="text" name="empleado_am" maxlength="40" /></td>
                                </tr>
                                <tr>
                                    <td>Correo:</td>
                                    <td><input type="text" name="empleado_correo" maxlength="50" /></td>
                                </tr>
                                <tr>
                                    <td>Direcci&oacute;n:</td>
                                    <td><input type="text" name="empleado_direccion" maxlength="50" /></td>
                                </tr>
                                <tr>
                                    <td>Fono Fijo:</td>
                                    <td><input type="text" name="empleado_fijo" maxlength="15" /><span class="valueEjemplo">025559999</span></td>
                                </tr>
                                <tr>
                                    <td>Fono M&oacute;vil:</td>
                                    <td><input type="text" name="empleado_movil" maxlength="15" /><span class="valueEjemplo">081234567</span></td>
                                </tr>
                                <tr>
                                    <td>Tipo empleado:</td>
                                    <td>
                                        <select name="empleado_tipo">
                                            <?php
                                            $tipos_empleado = array();
                                            $tipos_empleado = $instancia_controlador_empleados->getTiposEmpleados();
                                            for ($contador = 0; $contador < count($tipos_empleado); $contador++) {
                                                echo "<option value='$tipos_empleado[$contador]'";
                                                echo ">";
                                                echo $tipos_empleado[$contador];
                                                echo "</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="botones">
                            <a class="quitar_solo" href="javascript:document.crearempleado.reset()">LIMPIAR</a>
                            <a class="agregar_solo" href="javascript:document.crearempleado.submit()">CREAR</a>
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