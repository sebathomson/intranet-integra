<?php

require_once (PATH_ROOT . '/controlador/functions/db_connect.php');
require_once (PATH_ROOT . '/modelo/venta.php');

class VentaServicio extends Venta {

    var $VtaS_id;
    var $VtaS_Nombre;
    var $VtaS_Descripcion;
    var $VtaS_RutCliente;
    var $VtaS_RutEmpleado;
        
    function __construct($v_vta_serv_id, $v_vta_serv_nombre, $v_vta_serv_descripcion, $v_vta_serv_rutcliente = null, $v_vta_serv_rutempleado = null) {
    $this->VtaS_id = $v_vta_serv_id;
    $this->VtaS_Nombre= $v_vta_serv_nombre;
    $this->VtaS_Descripcion = $v_vta_serv_descripcion;
    $this->VtaS_RutCliente = $v_vta_serv_rutcliente;
    $this->VtaS_RutEmpleado = $v_vta_serv_rutempleado;
    }

    function VtaS_Nueva() {

        $queryServicio = "INSERT INTO servicio (Nombre, Descripcion)
                                VALUES ('$this->VtaS_Nombre', '$this->VtaS_Descripcion')";

        db_connect();

        mysql_query($queryServicio);
        $validadorServicio = mysql_affected_rows();
        $ultimoID = MYSQL_INSERT_ID();

        if ($validadorServicio !== 0) {
            $validarServicio = true;
        } else {
            $validarServicio = false;
        }

        $queryVentaDeServicio = "INSERT INTO venta_de_servicio (Servicio_ID, Rut_Cli, Rut_Emp, Fecha)
                                        VALUES ('$ultimoID', '$this->VtaS_RutCliente', '$this->VtaS_RutEmpleado', CURRENT_TIMESTAMP)";

        mysql_query($queryVentaDeServicio);
        $validadorVentaServicio = mysql_affected_rows();

        db_close();

        if ($validadorVentaServicio !== 0) {
            $validarVentaServicio = true;
        } else {
            $validarVentaServicio = false;
        }

        if ($validarServicio == true AND $validarVentaServicio == true) {
            return $ultimoID;
        } else {
            return false;
        }
    }

    function VtaS_Ver() {

        $venta = array();

        $queryVer = "SELECT servicio.Servicio_ID, servicio.Nombre, servicio.Descripcion, cliente.Nombre_Cli, venta_de_servicio.Fecha
                        FROM servicio, cliente, venta_de_servicio
                        WHERE servicio.Servicio_ID = venta_de_servicio.Servicio_ID
                              AND venta_de_servicio.Rut_Cli = cliente.Rut_Cli
                              AND servicio.Servicio_ID = $this->VtaS_id";

        db_connect();

        $resulset = mysql_query($queryVer);
        $contador = 0;

        while ($row = mysql_fetch_array($resulset)) {
            $venta[$contador][0] = $row["Servicio_ID"];
            $venta[$contador][1] = $row["Nombre"];
            $venta[$contador][2] = $row["Descripcion"];
            $venta[$contador][3] = $row["Nombre_Cli"];
            $venta[$contador][4] = $row["Fecha"];
            $contador++;
        }
        db_close();
        return $venta;
    }

    function VtaS_Buscar($clave, $filtro) {

        if ($filtro == "servicio_cliente") {
            $queryBuscar = "SELECT servicio.Servicio_ID, servicio.Nombre, servicio.Descripcion, cliente.Nombre_Cli, venta_de_servicio.Fecha
                                    FROM servicio, cliente, venta_de_servicio
                                    WHERE servicio.Servicio_ID = venta_de_servicio.Servicio_ID
                                       AND venta_de_servicio.Rut_Cli = cliente.Rut_Cli
                                       AND (cliente.Nombre_Cli LIKE '%$clave%' OR cliente.Rut_Cli LIKE '%$clave%')";
        }

        if ($filtro == "servicio_nombre") {
            $queryBuscar = "SELECT servicio.Servicio_ID, servicio.Nombre, servicio.Descripcion, cliente.Nombre_Cli, venta_de_servicio.Fecha
                                    FROM servicio, cliente, venta_de_servicio
                                    WHERE servicio.Servicio_ID = venta_de_servicio.Servicio_ID
                                       AND venta_de_servicio.Rut_Cli = cliente.Rut_Cli
                                       AND servicio.Nombre LIKE '%$clave%'";
        }

        if ($filtro == "servicio_id") {
            $queryBuscar = "SELECT servicio.Servicio_ID, servicio.Nombre, servicio.Descripcion, cliente.Nombre_Cli, venta_de_servicio.Fecha
                                    FROM servicio, cliente, venta_de_servicio
                                    WHERE servicio.Servicio_ID = venta_de_servicio.Servicio_ID
                                       AND venta_de_servicio.Rut_Cli = cliente.Rut_Cli
                                       AND servicio.Servicio_ID LIKE '%$clave%'";
        }
        $venta = array();
        db_connect();
        $resulsetNombre = mysql_query($queryBuscar);
        $contador = 0;
        while ($row = mysql_fetch_array($resulsetNombre)) {
            $venta[$contador][0] = $row["Servicio_ID"];
            $venta[$contador][1] = $row["Nombre"];
            $venta[$contador][2] = $row["Descripcion"];
            $venta[$contador][3] = $row["Nombre_Cli"];
            $venta[$contador][4] = $row["Fecha"];
            $contador++;
        }
        db_close();
        return $venta;
    }

    function VtaS_Modificar() {
        $queryServicio = "UPDATE servicio
                            SET Nombre = '$this->VtaS_Nombre', Descripcion = '$this->VtaS_Descripcion'
                            WHERE SERVICIO_ID = $this->VtaS_id";
        db_connect();
        $return = mysql_query($queryServicio);
        db_close();
        return $return;
    }

}

?>