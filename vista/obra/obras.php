<?php
require_once("../../controlador/controlador_obras.php");

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
if (isset($_GET["servicio_id"])) {
    $servicio_id = $_GET["servicio_id"];
} else {
    $servicio_id = "";
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
                <li><a href="servicios.php">HOME SERVICIOS</a></li>
                <li><a href="?seccion=crear">CREAR</a></li>
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
                <span id="titleseccion">OBRAS</span>
                <img class="left" alt="" src="../images/title_right.png"/>
            </div>
            <img class="right" alt="" src="../images/contenedor_corner_right_top.png"/>
        </div>
        <?php
        switch ($seccion) {
            case "ver":
                if (isset($_GET["id"])) {
                    $obra_id = $_GET["id"];
                } else {
                    ?>
                    <script> 
                        location.href='?seccion=buscar'; 
                    </script>
                    <?php
                }

                $obra = array();
                $obra = $instancia_controlador_obras->obra_ver($obra_id);

                $obra_nombre = $obra[1];
                $obra_descripcion = $obra[2];
                $obra_servicio_id = $obra[3];
                $obra_fecha = $obra[4];
                $obra_estado = $obra[5];
                $obra_nombre_cliente = $obra[6];
                $obra_obreros = array();
                $obra_obreros = $obra[7];
                $obra_supervisores = array();
                $obra_supervisores = $obra[8];
                $obra_materiales = array();
                $obra_materiales = $obra[9];
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
                                <td>ID Obra:</td>
                                <td><?php echo $obra_id; ?></td>
                            </tr>
                            <tr>
                                <td>Nombre Obra:</td>
                                <td><?php echo $obra_nombre; ?></td>
                            </tr>
                            <tr>
                                <td>Descripci&oacute;n Obra:</td>
                                <td><?php echo $obra_descripcion; ?></td>
                            </tr>
                            <tr>
                                <td>ID Servicio:</td>
                                <td><?php echo $obra_servicio_id; ?></td>
                            </tr>
                            <tr>
                                <td>Cliente:</td>
                                <td><?php echo $obra_nombre_cliente; ?></td>
                            </tr>
                            <tr>
                                <td>Fecha Inicio:</td>
                                <td><?php echo $obra_fecha; ?></td>
                            </tr>
                            <tr>
                                <td>Estado:</td>
                                <td><?php echo $obra_estado; ?></td>
                            </tr>
                            <tr>
                                <td>Supervisor(es):</td>
                                <td>
                                    <?php
                                    if (count($obra_supervisores) == 0) {
                                        echo "Obra sin supervisores";
                                    } else {
                                        ?>
                                        <ol>
                                            <?php
                                            for ($i = 0; $i < count($obra_supervisores); $i++) {
                                                echo "<li>";
                                                echo $obra_supervisores[$i];
                                                echo "</li>";
                                            }
                                            ?>
                                        </ol>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Obreros:</td>
                                <td>
                                    <?php
                                    if (count($obra_obreros) == 0) {
                                        echo "Obra sin obreros";
                                    } else {
                                        ?>
                                        <ol>
                                            <?php
                                            for ($i = 0; $i < count($obra_obreros); $i++) {
                                                echo "<li>";
                                                echo $obra_obreros[$i];
                                                echo "</li>";
                                            }
                                            ?>
                                        </ol>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Material Utilizado:</td>
                                <td>
                                    <?php
                                    if (count($obra_materiales) == 0) {
                                        echo "Obra sin materiales";
                                    } else {
                                        ?>                                        
                                        <ul>
                                            <?php
                                            for ($i = 0; $i < count($obra_materiales); $i++) {
                                                echo "<li>";
                                                echo "(" . $obra_materiales[$i][1] . ")     - " . $obra_materiales[$i][2];
                                                echo "</li>";
                                            }
                                            ?>
                                        </ul>
                                    <?php } ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- CONTENIDO FIN-->	
                    <div class="clear"></div>
                    <div class="botones" style="margin-bottom: 50px">
                        <form action="obras.php" name="modificarservicio" method="get">
                            <input type="hidden" name="id" value="<?php echo $obra_id; ?>" /> 
                            <input type="hidden" name="seccion" value="modificar" /> 
                        </form>
                        <a class="quitar_2" href="JavaScript:history.back();">VOLVER</a>
                        <a class="agregar_2" href="javascript:document.modificarservicio.submit()">MODIFICAR</a>
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
                    $filtro = "obra_id";
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
                                            <option value="obra_nombre">NOMBRE</option>                                            
                                            <option value="obra_id">ID OBRA</option>
                                            <option value="servicio_id">ID SERVICIO</option>
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
                        $obra = array();
                        $obra = $instancia_controlador_obras->obra_buscar($busqueda, $filtro);
                        if ($obra == false) {
                            echo "<SCRIPT type='text/javascript'>window.onload=busquedaError;</SCRIPT>";
                        } else {
                            ?>
                            <!--INICIO RESULTADO BUSQUEDA-->
                            <table id="buscar" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID OBRA</th>
                                        <th>NOMBRE</th>
                                        <th>ID SERVICIO</th>
                                        <th>ESTADO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($x = 0; $x < count($obra); $x++) {
                                        $obra_id = $obra[$x][0];
                                        $obra_nombre = $obra[$x][2];
                                        $servicio_id = $obra[$x][1];
                                        $servicio_estado = $obra[$x][3];

                                        echo "<tr>";
                                        echo "<td><a id='enlace' href='obras.php?seccion=ver&id=$obra_id'>$obra_id</a></td>";
                                        echo "<td>$obra_nombre</td>";
                                        echo "<td>$servicio_id</td>";
                                        echo "<td>$servicio_estado</td>";
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
                    $obra_id = $_GET["id"];
                } else {
                    ?>
                    <script> 
                        location.href='?seccion=buscar'; 
                    </script>
                    <?php
                }

                $obra = array();
                $obra = $instancia_controlador_obras->obra_ver($obra_id);

                $obra_nombre = $obra[1];
                $obra_descripcion = $obra[2];
                $obra_servicio_id = $obra[3];
                $obra_fecha = $obra[4];
                $obra_estado = $obra[5];
                $obra_nombre_cliente = $obra[6];
                $obra_obreros = array();
                $obra_obreros = $obra[7];
                $obra_supervisores = array();
                $obra_supervisores = $obra[8];
                $obra_materiales = array();
                $obra_materiales = $obra[9];
                ?>
                <div id="contenedor">
                    <div class="clear"></div>
                    <!-- TITULO SECCION -->
                    <span id="title">MODIFICAR</span>
                    <!-- TITULO SECCION -->
                    <div class="clear"></div>	
                    <!-- CONTENIDO INICIO-->
                    <form name="agregarmat" action="?seccion=buscar" method="post">
                        <input type="hidden" value="ID_DE_LA_OBRA" name="valor" /> 
                    </form>
                    <form name="modificarobra" method="POST" action="../../controlador/controlador_obras.php?obraccion=modificar">
                        <input type="hidden" name="obra_id" value="<?php echo $obra_id; ?>" />
                        <table id="formularios" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td>ID Obra:</td>
                                    <td><?php echo $obra_id; ?></td>
                                </tr>
                                <tr>
                                    <td>Nombre Obra:</td>
                                    <td><input type="text"  name="obra_nombre" value="<?php echo $obra_nombre; ?>"/></td>
                                </tr>
                                <tr>
                                    <td>Descripci&oacute;n Obra:</td>
                                    <td><textarea name="obra_descripcion"><?php echo $obra_descripcion ?></textarea></td>
                                </tr>
                                <tr>
                                    <td>ID Servicio:</td>
                                    <td><?php echo $obra_servicio_id; ?></td>
                                </tr>
                                <tr>
                                    <td>Cliente:</td>
                                    <td><?php echo $obra_nombre_cliente; ?></td>
                                </tr>
                                <tr>
                                    <td>Fecha Inicio:</td>
                                    <td><?php echo $obra_fecha ?></td>
                                </tr>
                                <tr>
                                    <td>Estado:</td>
                                    <td>
                                        <select name="obra_Estado">
                                            <?php
                                            if ($obra_estado == "Finalizada") {
                                                echo "<option selected='selected' value='1'>Finalizada</option>";
                                                echo "<option value='0'>En Curso</option>";
                                            } else {
                                                echo "<option selected='selected' value='0'>En Curso</option>";
                                                echo "<option value='1'>Finalizada</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Supervisor:</td>
                                    <td>Agregar:
                                        <select name="addsupervisor">
                                            <option value="no-option">Seleccionar Empleado</option>
                                            <?php
                                            $empleados = array();

                                            $empleados = $instancia_controlador_empleados->empleados_listar("", "");

                                            if (count($empleados) == 0) {
                                                echo "<option value='no-option'>";
                                                echo "Sin Empleados";
                                                echo "</option>";
                                            } else {
                                                for ($i = 0; $i < count($empleados); $i++) {
                                                    $empleado_rut = $empleados[$i][0];
                                                    $empleado_nombre = $empleados[$i][1];

                                                    echo "<option value='$empleado_rut'>";
                                                    echo "($empleado_rut) $empleado_nombre";
                                                    echo "</option>";
                                                }
                                            }
                                            ?>
                                        </select> | Quitar:                                        
                                        <select name="delsupervisor">
                                            <option value="no-option">Seleccionar Empleado</option>
                                            <?php
                                            $empleados = array();

                                            $empleados = $instancia_controlador_empleados->empleados_listar($obra_id, "");

                                            if (count($empleados) == 0) {
                                                echo "<option value='no-option'>";
                                                echo "Sin Supervisores";
                                                echo "</option>";
                                            } else {
                                                for ($i = 0; $i < count($empleados); $i++) {
                                                    $empleado_rut = $empleados[$i][0];
                                                    $empleado_nombre = $empleados[$i][1];

                                                    echo "<option value='$empleado_rut'>";
                                                    echo "($empleado_rut) $empleado_nombre";
                                                    echo "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Obreros:</td>
                                    <td>Agregar: 
                                        <select name="addobrero">
                                            <option value="no-option">Seleccionar Empleado</option>
                                            <?php
                                            $empleados = array();

                                            $empleados = $instancia_controlador_empleados->empleados_listar("", "");

                                            if (count($empleados) == 0) {
                                                echo "<option value='no-option'>";
                                                echo "Sin Obreros";
                                                echo "</option>";
                                            } else {
                                                for ($i = 0; $i < count($empleados); $i++) {
                                                    $empleado_rut = $empleados[$i][0];
                                                    $empleado_nombre = $empleados[$i][1];

                                                    echo "<option value='$empleado_rut'>";
                                                    echo "($empleado_rut) $empleado_nombre";
                                                    echo "</option>";
                                                }
                                            }
                                            ?>
                                        </select> | Quitar:                                        
                                        <select name="delobrero">
                                            <option value="no-option">Seleccionar Empleado</option>
                                            <?php
                                            $empleados = array();

                                            $empleados = $instancia_controlador_empleados->empleados_listar($obra_id, "obrero");

                                            if (count($empleados) == 0) {
                                                echo "<option value='no-option'>";
                                                echo "Sin Empleados";
                                                echo "</option>";
                                            } else {
                                                for ($i = 0; $i < count($empleados); $i++) {
                                                    $empleado_rut = $empleados[$i][0];
                                                    $empleado_nombre = $empleados[$i][1];

                                                    echo "<option value='$empleado_rut'>";
                                                    echo "($empleado_rut) $empleado_nombre";
                                                    echo "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                    <!-- CONTENIDO FIN-->	
                    <div class="botones" style="margin-bottom: 50px;">
                        <a class="quitar_2" href="JavaScript:history.back();">CANCELAR</a>
                        <a class="agregar_2" href="javascript:document.modificarobra.submit()">MODIFICAR</a>
                    </div>
                    <div class="clear"></div>
                    <!-- TITULO SECCION -->
                    <span id="title">MATERIALES</span>
                    <!-- TITULO SECCION -->
                    <div class="clear"></div>	
                    <table id="ver">
                        <tbody>
                            <tr>
                                <td>Material Utilizado:</td>
                                <td>
                                    <?php
                                    if (count($obra_materiales) == 0) {
                                        echo "Obra sin materiales";
                                    } else {
                                        ?>                                        
                                        <ul>
                                            <?php
                                            for ($i = 0; $i < count($obra_materiales); $i++) {
                                                echo "<li>";
                                                echo "(" . $obra_materiales[$i][1] . ")" . $obra_materiales[$i][2];
                                                echo "</li>";
                                            }
                                            ?>
                                        </ul>
                                    <?php } ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <form name="agregarmaterial" method="POST" action="../../controlador/controlador_ventas.php">
                        <input type="hidden" name="obra_material" value="obra_material" />
                        <input type="hidden" name="obra_id" value="<?php echo $obra_id; ?>" />
                        <input type="hidden" name="obra_cliente" value="<?php echo $obra_rut_cliente; ?>" />
                        <input type="hidden" name="obra_nombre_cliente" value="<?php echo $obra_nombre_cliente; ?>" />
                    </form>
                    <div class="botones">
                        <a class="agregar_solo" href="javascript:document.agregarmaterial.submit()">AGREGAR</a>
                    </div>
                    <div class="clear"></div>
                </div>

                <?php
                break;
            default:
                $fecha = date("Y-m-d H:i:s");
                ?>
                <div id="contenedor">
                    <div class="clear"></div>
                    <!-- TITULO SECCION -->
                    <span id="title">NUEVO</span>
                    <!-- TITULO SECCION -->
                    <div class="clear"></div>		
                    <!-- CONTENIDO INICIO-->
                    <form name="crearobra" method="POST" action="../../controlador/controlador_obras.php?obraccion=nuevo">
                        <table id="formularios">
                            <tbody>
                                <tr>
                                    <td>Servicio ID:</td>
                                    <td><input type="text" name="obra_servicio_id" value="<?php echo $servicio_id ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Nombre:</td>
                                    <td><input type="text" name="obra_nombre" /></td>
                                </tr>
                                <tr>
                                    <td>Descripci&oacute;n:</td>
                                    <td>
                                        <textarea name="obra_descripcion" style="width:15em;">Descripci&oacute;n Obra...</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Fecha Inicio</td>
                                    <td><input type="text" name="obra_fecha_ini" value="<?php echo $fecha; ?>" /></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="botones">
                            <a class="quitar_solo" href="javascript:document.crearobra.reset()">LIMPIAR</a>
                            <a class="agregar_solo" href="javascript:document.crearobra.submit()">CREAR</a>
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
