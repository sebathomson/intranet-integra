<?php

require_once (PATH_ROOT . '/controlador/functions/db_connect.php');

class Proveedor {

    var $proveedor_rut;
    var $proveedor_nombre;
    var $proveedor_correo;
    var $proveedor_direccion;
    var $proveedor_fono_fijo;
    var $proveedor_fono_movil;

    function __construct($v_rut, $v_nombre, $v_correo, $v_direccion, $v_fono_fijo, $v_fono_movil) {
        $this->proveedor_rut = $v_rut;
        $this->proveedor_nombre = $v_nombre;
        $this->proveedor_correo = $v_correo;
        $this->proveedor_direccion = $v_direccion;
        $this->proveedor_fono_fijo = $v_fono_fijo;
        $this->proveedor_fono_movil = $v_fono_movil;
    }

    function Prov_Nuevo() {


        $proveedor_rut2 = str_replace(".", "", $this->proveedor_rut);

        $queryNuevo = "INSERT INTO proveedor (Rut_Prov, Nombre_Prov, Correo_Prov, Direccion_Prov, Fono_fijo_Prov, Fono_Movil_Prov)
                            VALUES ('$proveedor_rut2', '$this->proveedor_nombre', '$this->proveedor_correo', '$this->proveedor_direccion' , '$this->proveedor_fono_fijo', '$this->proveedor_fono_movil');";
        db_connect();
        $validador = mysql_query($queryNuevo);
        db_close();
        if ($validador) {
            $return = true;
        } else {
            $return = false;
        }
        return $return;
    }

    function Prov_Modificar($activacion) {

        $queryModificar = "UPDATE proveedor 
                                SET Nombre_Prov = '$this->proveedor_nombre', Correo_Prov = '$this->proveedor_correo', 
                                    Direccion_Prov = '$this->proveedor_direccion', Fono_fijo_Prov = '$this->proveedor_fono_fijo', 
                                    Fono_Movil_Prov = '$this->proveedor_fono_movil', Activacion = $activacion
                                WHERE Rut_Prov = '$this->proveedor_rut'";
        db_connect();
        $validador = mysql_query($queryModificar);
        db_close();
        if ($validador) {
            $return = true;
        } else {
            $return = false;
        }
        return $return;
    }

    function Prov_Ver() {

        $proveedor = array();

        db_connect();

        $queryVer = "SELECT Rut_Prov, Nombre_Prov, Correo_Prov, Direccion_Prov, Fono_fijo_Prov, Fono_Movil_Prov, Activacion
                           FROM proveedor
                           WHERE Rut_Prov = '$this->proveedor_rut';";

        $resulset = mysql_query($queryVer);

        while ($row = mysql_fetch_array($resulset)) {
            $proveedor[0] = $row["Rut_Prov"];
            $proveedor[1] = $row["Nombre_Prov"];
            $proveedor[2] = $row["Correo_Prov"];
            $proveedor[3] = $row["Direccion_Prov"];
            $proveedor[4] = $row["Fono_fijo_Prov"];
            $proveedor[5] = $row["Fono_Movil_Prov"];

            $proveedor_estado = $row["Activacion"];

            if ($proveedor_estado == 0) {
                $proveedor[6] = "Desactivado";
            } else {
                $proveedor[6] = "Activado";
            }
        }
        db_close();
        return $proveedor;
    }

    function Prov_Buscar($filtro, $clave, $activacion) {
        if ($filtro == "proveedor_rut") {
            $queryProveedorBuscar = "SELECT Rut_Prov, Nombre_Prov, Correo_Prov, Direccion_Prov, Fono_fijo_Prov, Fono_Movil_Prov, Activacion
                                    FROM proveedor
                                    WHERE Rut_Prov LIKE '%$clave%' AND Activacion = '$activacion'";
        }

        if ($filtro == "proveedor_nombre") {
            $queryProveedorBuscar = "SELECT Rut_Prov, Nombre_Prov, Correo_Prov, Direccion_Prov, Fono_fijo_Prov, Fono_Movil_Prov, Activacion
                                    FROM proveedor
                                    WHERE Nombre_Prov LIKE '%$clave%' AND Activacion = '$activacion'";
        }
        $proveedor = array();

        db_connect();
        $resulsetNom = mysql_query($queryProveedorBuscar);

        $contador = 0;

        while ($rowNom = mysql_fetch_array($resulsetNom)) {
            $proveedor[$contador][0] = $rowNom["Rut_Prov"];
            $proveedor[$contador][1] = $rowNom["Nombre_Prov"];
            $proveedor[$contador][2] = $rowNom["Correo_Prov"];
            $proveedor[$contador][3] = $rowNom["Direccion_Prov"];
            $proveedor[$contador][4] = $rowNom["Fono_fijo_Prov"];
            $proveedor[$contador][5] = $rowNom["Fono_Movil_Prov"];
            $proveedor[$contador][6] = $rowNom["Activacion"];
            $contador++;
        }
        db_close();
        return $proveedor;
    }

    function getProveedor() {

        $proveedor = array();
        db_connect();

        $queryP = "SELECT Rut_Prov, Nombre_Prov
                    FROM proveedor
                    WHERE Activacion = 1";
        $p = mysql_query($queryP);
        $contador = 0;
        While ($row = mysql_fetch_array($p)) {
            $proveedor[$contador][0] = $row["Rut_Prov"];
            $proveedor[$contador][1] = $row["Nombre_Prov"];
            $contador++;
        }

        db_close();
        return $proveedor;
    }

}

?>