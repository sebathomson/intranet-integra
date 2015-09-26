<?php

require_once ("controlador_principal.php");

require_once (PATH_ROOT . '/modelo/cliente.php');
require_once (PATH_ROOT . '/modelo/usuario.php'); // para buscar el ID del usuario.
require_once (PATH_ROOT . '/modelo/venta.php');
require_once (PATH_ROOT . '/modelo/ventaservicio.php');
require_once (PATH_ROOT . '/modelo/lineadeventaobra.php');
require_once (PATH_ROOT . '/modelo/lineadeventainsumo.php');
require_once (PATH_ROOT . '/controlador/functions/validar.php');
require_once (PATH_ROOT . '/controlador/controlador_administracion_usuarios.php'); // GetRut del usuario!
require_once (PATH_ROOT . '/controlador/controlador_administracion_clientes.php');

class controlador_ventas {

    function venta_insumos() {

        $insumo_cliente_rut_sin = $_POST["insumo_cliente_rut"];
        $insumo_cliente_nombre = $_POST["insumo_cliente_nombre"];

        if (validarRut($insumo_cliente_rut_sin) AND strlen($insumo_cliente_nombre) > 4) {

            $insumo_cliente_rut = str_replace(".", "", $insumo_cliente_rut_sin);
            $clientes = array();
            $clientes_instancia = new Cliente($insumo_cliente_rut, 0, 0, 0, 0, 0);
            $clientes = $clientes_instancia->Cli_Ver();

            if (count($clientes) == 0) {

                $registro = "";
                $registro = $_POST["confirmar"];

                if ($registro == "nocliente") {

                    $insumo_descripcion = "Venta de Insumos";
                    $venta = $_POST["venta_tipo"];
                    $venta_cabecera = array();
                    $venta_cabecera[0] = $insumo_cliente_rut;
                    $venta_cabecera[1] = $insumo_cliente_nombre;
                    $venta_cabecera[2] = $insumo_descripcion;
                    $venta_cabecera[3] = $venta;
                    $_SESSION['venta_cabecera'] = $venta_cabecera;
                    unset($_SESSION['carro']);
                    header("Location: ../vista/venta/stock_carro.php");
                } elseif ($registro == "sicliente") {

                    $cliente_rut = $insumo_cliente_rut;
                    $cliente_nombre = $insumo_cliente_nombre;
                    $cliente_correo = $_POST["cliente_correo"];
                    $cliente_direccion = $_POST["cliente_direccion"];
                    $cliente_movil = $_POST["cliente_fmovil"];
                    $cliente_fijo = $_POST["cliente_ffijo"];

                    if (validarRut($cliente_rut) AND validarNombre($cliente_nombre) AND validarEmail($cliente_correo) AND validarUbicacion($cliente_direccion) AND
                            validarFonoFijo($cliente_fijo) AND validarFonoMovil($cliente_movil)) {

                        $cliente_instancia = new Cliente($cliente_rut, $cliente_nombre, $cliente_correo, $cliente_direccion, $cliente_fijo, $cliente_movil);
                        $validador = $cliente_instancia->Cli_Nuevo();

                        if ($validador == FALSE) {
                            header("Location: ../vista/venta/insumos.php?clienterut=$insumo_cliente_rut&clientenombre=$insumo_cliente_nombre&mensaje=clienteError");
                        } else {
                            $insumo_descripcion = "Venta de Insumos";
                            $venta = $_POST["venta_tipo"];
                            $venta_cabecera = array();
                            $venta_cabecera[0] = $insumo_cliente_rut;
                            $venta_cabecera[1] = $insumo_cliente_nombre;
                            $venta_cabecera[2] = $insumo_descripcion;
                            $venta_cabecera[3] = $venta;

                            $_SESSION['venta_cabecera'] = $venta_cabecera;
                            unset($_SESSION['carro']);

                            header("Location: ../vista/venta/stock_carro.php");
                        }
                    } else {
                        header("Location: ../vista/venta/insumos.php?seccion=crear&mensaje=crearError");
                    }
                } else {
                    header("Location: ../vista/venta/insumos.php?clienterut=$insumo_cliente_rut&clientenombre=$insumo_cliente_nombre");
                }
            } else {
                $insumo_cliente_nombre = $clientes[1];
                $insumo_descripcion = "Venta de Insumos";
                $venta = $_POST["venta_tipo"];

                $venta_cabecera = array();

                $venta_cabecera[0] = $insumo_cliente_rut;
                $venta_cabecera[1] = $insumo_cliente_nombre;
                $venta_cabecera[2] = $insumo_descripcion;
                $venta_cabecera[3] = $venta;

                $_SESSION['venta_cabecera'] = $venta_cabecera;
                unset($_SESSION['carro']);

                header("Location: ../vista/venta/stock_carro.php");
            }
        } else {
            header("Location: ../vista/venta/insumos.php?seccion=crear&mensaje=ventaError");
        }
    }

    function venta_servicios() {
        $servicio_cliente_rut = $_POST["servicio_cliente_rut"];
        $servicio_nombre = $_POST["servicio_nombre"];
        $servicio_descripcion = $_POST["servicio_descripcion"];

        $instancia_controlador_usuario = new controlador_administracion_usuarios();

        $rut_usuario = $instancia_controlador_usuario->getRut();

        if ($servicio_cliente_rut == "no-option" OR $servicio_cliente_rut == "no-cliente") {
            header("Location: ../vista/venta/servicios.php");
        }

        $instancia_servicio = new VentaServicio(0, $servicio_nombre, $servicio_descripcion, $servicio_cliente_rut, $rut_usuario);
        $servicio_validador = $instancia_servicio->VtaS_Nueva();

        if ($servicio_validador == false) {
            header("Location: ../vista/venta/servicios.php");
        } else {
            header("Location: ../vista/obra/servicios.php?seccion=ver&id=$servicio_validador");
        }
    }

    function egreso_insumo() {
        $egreso_identificador = $_POST["egreso_identificador"]; // RUT DEL CLIENTE!!
        $count_materiales = $_POST["count_materiales"];
        $egreso_materiales = array();

        for ($contador_materiales = 0; $contador_materiales < $count_materiales; $contador_materiales++) {
            $post_id = "material_" . $contador_materiales . "_material_id";
            $post_cantidad = "material_" . $contador_materiales . "_material_cantidad";
            $post_bodega = "material_" . $contador_materiales . "_bodega_id";
            $egreso_materiales[$contador_materiales]["material_id"] = $_POST[$post_id];
            $egreso_materiales[$contador_materiales]["material_cantidad"] = $_POST[$post_cantidad];
            $egreso_materiales[$contador_materiales]["bodega_id"] = $_POST[$post_bodega];
        }
        $instancia_controlador_usuario = new controlador_administracion_usuarios();

        $rut_usuario = $instancia_controlador_usuario->getRut();

        $instancia_venta = new Venta(0, $egreso_identificador, $rut_usuario);
        $venta_id = $instancia_venta->Vta_Nueva();

        for ($contador = 0; $contador < count($egreso_materiales); $contador++) {
            $material_id = $egreso_materiales[$contador]["material_id"];
            $material_cantidad = $egreso_materiales[$contador]["material_cantidad"];
            $bodega_id = $egreso_materiales[$contador]["bodega_id"];

            $instancia_lineadeventa = new LineaDeVentaInsumo($venta_id, $bodega_id, $material_id, $rut_usuario, $material_cantidad);
            $instancia_lineadeventa->LineaVta_Nueva();
            unset($instancia_lineadeventa);

            $carro = $_SESSION['carro'];

            unset($carro[md5($material_id)]);

            $_SESSION['carro'] = $carro;
        }

        header("Location: ../vista/venta/insumos.php?mensaje=ventaOk");
    }

    function egreso_servicios() {
        $egreso_identificador = $_POST["egreso_identificador"]; // ID de la OBRA.
        $count_materiales = $_POST["count_materiales"];
        $egreso_materiales = array();

        for ($contador_materiales = 0; $contador_materiales < $count_materiales; $contador_materiales++) {
            $post_id = "material_" . $contador_materiales . "_material_id";
            $post_cantidad = "material_" . $contador_materiales . "_material_cantidad";
            $post_bodega = "material_" . $contador_materiales . "_bodega_id";
            $egreso_materiales[$contador_materiales]["material_id"] = $_POST[$post_id];
            $egreso_materiales[$contador_materiales]["material_cantidad"] = $_POST[$post_cantidad];
            $egreso_materiales[$contador_materiales]["bodega_id"] = $_POST[$post_bodega];
        }

        $instancia_controlador_usuario = new controlador_administracion_usuarios();

        $rut_usuario = $instancia_controlador_usuario->getRut();
        

        for ($contador = 0; $contador < count($egreso_materiales); $contador++) {
            $material_id = $egreso_materiales[$contador]["material_id"];
            $material_cantidad = $egreso_materiales[$contador]["material_cantidad"];
            $bodega_id = $egreso_materiales[$contador]["bodega_id"];

            $instancia_lineadeventa = new LineaDeVentaObra($egreso_identificador, $bodega_id, $material_id, $rut_usuario, $material_cantidad);
            $instancia_lineadeventa->LineaVta_Nueva();
            
            unset($instancia_lineadeventa);

            $carro = $_SESSION['carro'];

            unset($carro[md5($material_id)]);

            $_SESSION['carro'] = $carro;
        }

        header("Location: ../vista/obra/obras.php?&seccion=ver&id=$egreso_identificador");
    }

    function buscar_ventas($estadistica) {

        if (!is_numeric($estadistica)) {
            $estadistica = 2012;
        }
        $insumos = array();
        $instancia_venta = new Venta(0, 0, 0);
        $insumos = $instancia_venta->Vta_buscar($estadistica);
        return $insumos;
    }

    function buscar_egresos($vista, $tipo_egreso, $busqueda) {
        switch ($vista) {
            case "Buscar":
                if ($tipo_egreso == "insumos") {
                    $validar = validarRut($busqueda);
                    if ($validar) {
                        $instancia_insumos = new LineaDeVentaInsumo(0, 0, 0, 0, 0);
                        $insumos = array();
                        $insumos = $instancia_insumos->LineaDeVenta_Buscar($busqueda);
                        $datos = $insumos[0];
                        return $datos;
                    } else {
                        return false;
                    }
                } elseif ($tipo_egreso == "obra") {
                    $validar = validarID($busqueda);
                    if ($validar) {
                        $obra_instancia = new Obra($busqueda, 0, 0, 0, 0);
                        $obra = array();
                        $obra = $obra_instancia->Obra_Ver();
                        $datos = array();
                        $datos[0][0] = $obra[0];
                        $datos[0][1] = $obra[10];
                        $datos[0][2] = $obra[4];
                        return $datos;
                        if ($obra == false) {
                            return false;
                        }
                        return $obra;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
                break;
            case "Ver":

                break;
            default:
                header("Location: ../vista/venta/buscar_egresos.php");
                break;
        }
    }

}

if (isset($_POST["venta_tipo"])) {
    $venta = $_POST["venta_tipo"];
} else {
    $venta = "";
}

if (isset($_POST["egreso_tipo"])) {
    $egreso = $_POST["egreso_tipo"];
} else {
    $egreso = "";
}

$instancia_controlador_ventas = new controlador_ventas();

if ($venta == "insumos") {
    $instancia_controlador_ventas->venta_insumos();
} elseif ($venta == "servicios") {
    $instancia_controlador_ventas->venta_servicios();
}

if ($egreso == "insumos") {
    $instancia_controlador_ventas->egreso_insumo();
} elseif ($egreso == "servicios") {
    $instancia_controlador_ventas->egreso_servicios();
}

if (isset($_POST["obra_material"])) {
    $obra_id = $_POST["obra_id"];
    $obra_cliente = $_POST["obra_cliente"];
    $obra_nombre_cliente = $_POST["obra_nombre_cliente"];
    $venta_cabecera = array();

    $venta_cabecera[0] = $obra_id;
    $venta_cabecera[1] = $obra_nombre_cliente;
    $venta_cabecera[2] = $obra_cliente;
    $venta_cabecera[3] = "servicios";

    $_SESSION['venta_cabecera'] = $venta_cabecera;

    unset($_SESSION['carro']);

    header("Location: ../vista/venta/stock_carro.php");
} else {
    
}
?>