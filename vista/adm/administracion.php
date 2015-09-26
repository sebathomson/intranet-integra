<?php
require_once('../../controlador/controlador_principal.php');

/* CONTROLAR EL ACCESO A LAS PÁGINAS */
$privilegios_pagina = array();
$privilegios_pagina[0] = "ADMINISTRADOR";
$instancia_controlador_principal->Validar_Acceso($privilegios_pagina);
/* CONTROLAR EL ACCESO A LAS PÁGINAS */

require_once('../../controlador/controlador_ventas.php');

$instancia_controlador_ventas = new controlador_ventas();

if (isset($_GET["estadistica"])) {

    if (is_numeric($_GET["estadistica"])) {
        $estadistica = $_GET["estadistica"];
    } else {
        $estadistica = date('Y');
    }
} else {
    $estadistica = date('Y');
}

$ventas = $instancia_controlador_ventas->buscar_ventas($estadistica);
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
        <!-- GRAFICO */ -->
        <script type="text/javascript" src="../javascript/chart/highcharts.js"></script>
        <script type="text/javascript">
		
            var chart;
            $(document).ready(function() {
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'container',
                        defaultSeriesType: 'column'
                    },
                    title: {
                        text: 'NIVEL DE VENTAS'
                    },
                    subtitle: {
                        text: 'Año <?php echo $estadistica; ?>'
                    },
                    xAxis: {
                        categories: [
                            'Ene', 
                            'Feb', 
                            'Mar', 
                            'Abr', 
                            'May', 
                            'Jun', 
                            'Jul', 
                            'AGo', 
                            'Sep', 
                            'Oct', 
                            'Nov', 
                            'Dic'
                        ]
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Cantidad'
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        backgroundColor: '#ebebeb',
                        align: 'left',
                        verticalAlign: 'top',
                        x: 100,
                        y: 70,
                        floating: true,
                        shadow: true
                    },
                    tooltip: {
                        formatter: function() {
                            return ''+
                                this.x +': '+ this.y;
                        }
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0,
                            borderWidth: 0
                        }
                    },
                    series: [{
                            name: 'Insumos',
                            data: [
<?php
echo $ventas['insumos'][1];
echo ', ';
echo $ventas['insumos'][2];
echo ', ';
echo $ventas['insumos'][3];
echo ', ';
echo $ventas['insumos'][4];
echo ', ';
echo $ventas['insumos'][5];
echo ', ';
echo $ventas['insumos'][6];
echo ', ';
echo $ventas['insumos'][7];
echo ', ';
echo $ventas['insumos'][8];
echo ', ';
echo $ventas['insumos'][9];
echo ', ';
echo $ventas['insumos'][10];
echo ', ';
echo $ventas['insumos'][11];
echo ', ';
echo $ventas['insumos'][12];
?>]
                    }, {
                        name: 'Servicios',
                        data: [
<?php
echo $ventas['servicios'][1];
echo ', ';
echo $ventas['servicios'][2];
echo ', ';
echo $ventas['servicios'][3];
echo ', ';
echo $ventas['servicios'][4];
echo ', ';
echo $ventas['servicios'][5];
echo ', ';
echo $ventas['servicios'][6];
echo ', ';
echo $ventas['servicios'][7];
echo ', ';
echo $ventas['servicios'][8];
echo ', ';
echo $ventas['servicios'][9];
echo ', ';
echo $ventas['servicios'][10];
echo ', ';
echo $ventas['servicios'][11];
echo ', ';
echo $ventas['servicios'][12];
?>]	
                        }]
                });
				
				
            });
				
        </script>
        <!-- GRAFICO */ -->        
        <!-- Fin Jscript -->
    </head>
    <body>
        <!-- INICIO MENU -->
        <div name="menu">
            <ul id="menu">
                <li id="lifirst"><a href="administracion.php"><img class="left" alt="Logo" src="../images/menu_left.png" width="206px" height="45px" /></a></li>
                <li><a href="usuarios.php?seccion=crear">USUARIOS</a></li>
                <li><a href="empleados.php?seccion=crear">EMPLEADOS</a></li>
                <li><a href="clientes.php?seccion=crear">CLIENTES</a></li>
                <li><a href="proveedores.php?seccion=crear">PROVEEDORES</a></li>
                <li><a href="bodegas.php?seccion=crear">BODEGAS</a></li>
                <li id="liend"><a id="cerrarsesion" class="editprofile" href="#">[Editar]</a> <a id="cerrarsesion" href="../../controlador/controlador_principal.php?accion=desconectar">[Desconectar]</a></li>
            </ul>
        </div>
        <!-- FIN MENU -->
        <div class="clear"></div>
        <!-- INICIO CONTENEDOR -->
        <div id="contenedortop">
            <img class="left" alt="" src="../images/contenedor_corner_left_top.png"/>
            <div name="titulo">
                <span id="titleseccion">ADMINISTRACI&Oacute;N</span>
                <img class="left" alt="" src="../images/title_right.png"/>
            </div>
            <img class="right" alt="" src="../images/contenedor_corner_right_top.png"/>
        </div>
        <div id="contenedor">
            <div class="clear"></div>
            <!-- TITULO SECCION -->
            <span id="title">BIENVENIDO</span>
            <!-- TITULO SECCION -->
            <div class="clear"></div>		
            <!-- CONTENIDO INICIO-->
            <div style="padding-top: 20px;">
                <div id="container" style="width: 650px; height: 400px; margin: 0 auto"></div>
            </div>
            <center>
                <form name="recargar" method="GET" action="">
                    <table id="formularios" cellspacing="0">
                        <tr>
                            <td><input type="text" name="estadistica" value="<?php echo $estadistica ?>" maxlength="4" style="text-align: center;" /></td>
                        </tr>
                    </table>
                </form>
            </center>
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