<?php

require_once (PATH_ROOT . '/controlador/functions/db_connect.php');

class Cliente {

    var $cliente_rut;
    var $cliente_nombre;
    var $cliente_correo;
    var $cliente_direccion;
    var $cliente_fono_fijo;
    var $cliente_fono_movil;

    function __construct($v_cliente_rut, $v_cliente_nombre, $v_cliente_correo, $v_cliente_direccion, $v_cliente_fono_fijo, $v_cliente_fono_movil) {
        $this->cliente_rut = $v_cliente_rut;
        $this->cliente_nombre = $v_cliente_nombre;
        $this->cliente_correo = $v_cliente_correo;
        $this->cliente_direccion = $v_cliente_direccion;
        $this->cliente_fono_fijo = $v_cliente_fono_fijo;
        $this->cliente_fono_movil = $v_cliente_fono_movil;
    }

    function Cli_Nuevo() {
        $cliente_rut2 = str_replace(".", "", $this->cliente_rut);

        $queryClienteNuevo = "INSERT INTO cliente (Rut_Cli, Nombre_Cli, Correo_Cli, Direccion_Cli, Fono_fijo_Cli, Fono_Movil_Cli)
                            VALUES ('$cliente_rut2', '$this->cliente_nombre', '$this->cliente_correo', '$this->cliente_direccion' , '$this->cliente_fono_fijo', '$this->cliente_fono_movil');";
        db_connect();
        $validador = mysql_query($queryClienteNuevo);
        db_close();
        if ($validador) {
            $return = true;
        } else {
            $return = false;
        }
        return $return;
    }

    function Cli_Modificar($activacion) {
        $queryClienteModificar = "UPDATE cliente 
                                SET Nombre_Cli = '$this->cliente_nombre', Correo_Cli = '$this->cliente_correo', 
                                    Direccion_Cli = '$this->cliente_direccion', Fono_fijo_Cli = '$this->cliente_fono_fijo', 
                                    Fono_Movil_Cli = '$this->cliente_fono_movil', Activacion = $activacion
                                WHERE Rut_Cli = '$this->cliente_rut'";
        db_connect();
        $validador = mysql_query($queryClienteModificar);
        db_close();
        if ($validador) {
            $return = true;
        } else {
            $return = false;
        }
        return $return;
    }

    function Cli_Ver() {

        $cliente = array();

        db_connect();

        $queryClienteVer = "SELECT Rut_Cli, Nombre_Cli, Correo_Cli, Direccion_Cli, Fono_fijo_Cli, Fono_Movil_Cli, Activacion
                           FROM cliente
                           WHERE Rut_Cli = '$this->cliente_rut';";

        $resultset = mysql_query($queryClienteVer);

        while ($row = mysql_fetch_array($resultset)) {
            $cliente[0] = $row["Rut_Cli"];
            $cliente[1] = $row["Nombre_Cli"];
            $cliente[2] = $row["Correo_Cli"];
            $cliente[3] = $row["Direccion_Cli"];
            $cliente[4] = $row["Fono_fijo_Cli"];
            $cliente[5] = $row["Fono_Movil_Cli"];

            $cliente_estado = $row["Activacion"];

            if ($cliente_estado == 0) {
                $cliente[6] = "Desactivado";
            } else {
                $cliente[6] = "Activado";
            }
        }
        db_close();
        return $cliente;
    }

    function Cli_Buscar($filtro, $clave, $activacion) {

        $cliente = array();

        if ($filtro == "cliente_rut") {
            $queryClienteBuscar = "SELECT Rut_Cli, Nombre_Cli, Correo_Cli, Direccion_Cli, Fono_fijo_Cli, Fono_Movil_Cli, Activacion
                           FROM cliente
                           WHERE Rut_Cli LIKE '%$clave%' AND Activacion = '$activacion'";
        }

        if ($filtro == "cliente_nombre") {
            $queryClienteBuscar = "SELECT Rut_Cli, Nombre_Cli, Correo_Cli, Direccion_Cli, Fono_fijo_Cli, Fono_Movil_Cli, Activacion
                                 FROM cliente
                                 WHERE Nombre_Cli LIKE '%$clave%' AND Activacion = '$activacion'";
        }
        db_connect();
        $resulsetRut = mysql_query($queryClienteBuscar);
        $contador = 0;

        while ($rowRut = mysql_fetch_array($resulsetRut)) {
            $cliente[$contador][0] = $rowRut["Rut_Cli"];
            $cliente[$contador][1] = $rowRut["Nombre_Cli"];
            $cliente[$contador][2] = $rowRut["Correo_Cli"];
            $cliente[$contador][3] = $rowRut["Direccion_Cli"];
            $cliente[$contador][4] = $rowRut["Fono_fijo_Cli"];
            $cliente[$contador][5] = $rowRut["Fono_Movil_Cli"];
            $cliente[$contador][6] = $rowRut["Activacion"];
            $contador++;
        }
        db_close();
        return $cliente;
    }

    function Cli_Get_lista() { // SOLO de clientes activados. 
        $queryClienteVer = "SELECT Rut_Cli, Nombre_Cli
                           FROM cliente
                           WHERE ACTIVACION = 1;";
        db_connect();

        $resultset = mysql_query($queryClienteVer);

        $contador = 0;
        $cliente = array();

        while ($row = mysql_fetch_array($resultset)) {
            $cliente[$contador][0] = $row["Rut_Cli"];
            $cliente[$contador][1] = $row["Nombre_Cli"];
            $contador++;
        }

        db_close();

        return $cliente;
    }

}

?>