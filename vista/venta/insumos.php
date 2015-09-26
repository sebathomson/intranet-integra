<?php
require_once("../../controlador/controlador_ventas.php");

if (isset($_GET["clienterut"])) {
    $clienterut = $_GET["clienterut"];
} else {
    $clienterut = "";
}
if (isset($_GET["clientenombre"])) {
    $clientenombre = $_GET["clientenombre"];
} else {
    $clientenombre = "";
}


if (isset($_GET["seccion"])) {
    $seccion = $_GET["seccion"];
} else {
    $seccion = "crear";
}
unset($_SESSION['venta_cabecera']);

if (isset($_SESSION['carro'])) {
    $carro = $_SESSION['carro'];
}else {
    $carro = false;
}


if ($carro) {
    foreach ($carro as $k => $v) {
        $k = $k;
        unset($carro[md5($v['materialID'])]);
        $_SESSION['carro'] = $carro;
    }
} else {
    $carro = false;
    $_SESSION['carro'] = $carro;
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
                <li><a href="?seccion=crear">VENTA DE INSUMOS</a></li>
                <?php
                if ($_SESSION["session_privilegio"] == "ADMINISTRADOR") {
                    ?>
                    <li><a href="servicios.php">VENTA DE SERVICIOS</a></li>
                    <li><a href="buscar_egresos.php">EGRESOS</a></li>
                    <?php
                }
                ?>                
                <li id="liend"><a id="cerrarsesion" class="editprofile" href="#">[Editar]</a> <a id="cerrarsesion" href="../../controlador/controlador_principal.php?accion=desconectar">[Desconectar]</a></li>
            </ul>
        </div>
        <!-- FIN MENU -->
        <div class="clear"></div>
        <!-- INICIO CONTENEDOR -->
        <div id="contenedortop">
            <img class="left" alt="" src="../images/contenedor_corner_left_top.png"/>
            <div name="titulo">
                <span id="titleseccion">VENTAS - INSUMOS</span>
                <img class="left" alt="" src="../images/title_right.png"/>
            </div>
            <img class="right" alt="" src="../images/contenedor_corner_right_top.png"/>
        </div>
        <div id="contenedor">
            <div class="clear"></div>
            <!-- TITULO SECCION -->
            <span id="title">NUEVO</span>
            <!-- TITULO SECCION -->
            <div class="clear"></div>		
            <!-- CONTENIDO INICIO-->
            <form name="crearventa" method="POST" action="../../controlador/controlador_ventas.php">
                <input type="hidden" name="venta_tipo" value="insumos" />
                <table id="formularios">
                    <tbody>
                        <tr>
                            <td>Rut Cliente:</td>
                            <td><input type="text" name="insumo_cliente_rut" value="<?php echo $clienterut ?>" size="12" maxlength="12"  /><span class="valueEjemplo">12345678-9</span></td>
                        </tr>
                        <tr>
                            <td>Nombre Cliente:</td>
                            <td><input type="text" name="insumo_cliente_nombre" value="<?php echo $clientenombre ?>" /></td>
                        </tr>
                    </tbody>
                </table>
                <div class="botones">
                    <a class="quitar_solo" href="javascript:document.crearventa.reset()">LIMPIAR</a>
                    <a class="agregar_solo" href="javascript:document.crearventa.submit()">CREAR</a>
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
        <script type="text/javascript">
            $(".editprofile").click(function() {
                $.msgbox("<p>Cambiar Password:</p>", {
                    type    : "prompt",
                    inputs  : [
                        {type: "password", label: "Ingrese Password Antigua:", required: true},
                        {type: "password", label: "Ingrese Password Nueva:", required: true},
                        {type: "password", label: "Repita Password Nueva:", required: true}
                    ],
                    buttons : [
                        {type: "submit", value: "Cambiar"},
                        {type: "cancel", value: "Salir"}
                    ]
                }, function(password_old, password_new, password_rep) {
                    if (password_old) {
                        document.write("<form method='POST' name='editarpassword' action='../../controlador/controlador_principal.php?accion=editar_password'>");
                        document.write("<input type='hidden' name='password_old' value='"+password_old+"' />");
                        document.write("<input type='hidden' name='password_new' value='"+password_new+"' />");
                        document.write("<input type='hidden' name='password_rep' value='"+password_rep+"' />");
                        document.write("<input type='hidden' name='url' value='"+document.location.href+"' />");
                        document.write("</form>");
                        document.editarpassword.submit();
                    }
                });                          
            });           
        </script>
        <?php
        if (isset($_GET["mensaje"])) {
            $mensaje = $_GET["mensaje"];
        } else {
            $mensaje = "";
        }
        if ($mensaje == 'ventaOk') {
            ?>
            <script type="text/javascript">
                function ventaOk(){
                                    
                    $.msgbox("<p>La venta ha quedado registrada.</p>", {
                        type: "confirm",
                        buttons : [
                            {type: "submit", value: "Si"}
                        ]
                    });
                }
                window.onload=ventaOk;
            </script>
            <?php
        }
        if ($clienterut == "") {
            
        } else {
            ?>
            <script type="text/javascript">
                function crearCliente(){
                    $.msgbox("<p>¿Quieres registrar al cliente?</p>", {
                        type: "confirm",
                        buttons : [
                            {type: "submit", value: "Si"},
                            {type: "submit", value: "No"},
                        ]
                    }, function(result) {
                        if(result == 'No'){
                            document.write("<form method='POST' name='crearVenta' action='../../controlador/controlador_ventas.php'>");
                            document.write("<input type='hidden' name='venta_tipo' value='insumos' />");
                            document.write("<input type='hidden' name='confirmar' value='nocliente' />");
                            document.write("<input type='hidden' name='insumo_cliente_rut' value='<?php echo $clienterut; ?>' />");
                            document.write("<input type='hidden' name='insumo_cliente_nombre' value='<?php echo $clientenombre; ?>' />");
                            document.write("</form>");
                            document.crearVenta.submit();
                        }else{
                            $.msgbox("<p>Rut: <b><?php echo $clienterut; ?></b><br />Nombre: <b><?php echo $clientenombre; ?></b></p>", {
                                type    : "prompt",
                                inputs  : [
                                    {type: "text", label: "Correo:", name: "correo", required: true},
                                    {type: "text", label: "Dirección:", name: "direccion", required: true},
                                    {type: "text", label: "Fono Fijo:", name: "ffijo", required: true},
                                    {type: "text", label: "Fono Móvil:", name: "fmovil", required: true}
                                ],
                                buttons : [
                                    {type: "submit", value: "Crear"},
                                    {type: "cancel", value: "Salir"}
                                ]
                            }, function(correo, direccion, ffijo, fmovil) {
                                if(correo, direccion, ffijo, fmovil){
                                    document.write("<form method='POST' name='crearCliente' action='../../controlador/controlador_ventas.php'>");
                                    document.write("<input type='hidden' name='venta_tipo' value='insumos' />");
                                    document.write("<input type='hidden' name='confirmar' value='sicliente' />");
                                    document.write("<input type='hidden' name='insumo_cliente_rut' value='<?php echo $clienterut; ?>' />");
                                    document.write("<input type='hidden' name='insumo_cliente_nombre' value='<?php echo $clientenombre; ?>' />");
                                    document.write("<input type='hidden' name='cliente_correo' value='"+correo+"' />");
                                    document.write("<input type='hidden' name='cliente_direccion' value='"+direccion+"' />");
                                    document.write("<input type='hidden' name='cliente_ffijo' value='"+ffijo+"' />");
                                    document.write("<input type='hidden' name='cliente_fmovil' value='"+fmovil+"' />");
                                    document.write("</form>");
                                    document.crearCliente.submit();
                                }
                            });
                        }
                    });
                }
                window.onload=crearCliente;
            </script>
            <?php
        }
        ?>
    </body>
</html>

