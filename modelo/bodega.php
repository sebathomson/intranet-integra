<?php

require_once (PATH_ROOT . '/controlador/functions/db_connect.php');

class Bodega {

    var $bodega_id;
    var $bodega_ubicacion;
    var $bodega_descripcion;

    function __construct($v_bodega_id, $v_bodega_ubicacion, $v_bodega_descripcion) {
        $this->bodega_id = $v_bodega_id;
        $this->bodega_ubicacion = $v_bodega_ubicacion;
        $this->bodega_descripcion = $v_bodega_descripcion;
    }

    function Bod_Nueva() {
        $queryBodegaNueva = "INSERT INTO bodega (Ubicacion, Descripcion_Bod)
                            VALUES ('$this->bodega_ubicacion', '$this->bodega_descripcion')";
        db_connect();

        $validador = mysql_query($queryBodegaNueva);
        $this->bodega_id = MYSQL_INSERT_ID();

        db_close();

        if ($validador) {
            $return = $this->bodega_id;
        } else {
            $return = false;
        }
        return $return;
    }

    function Bod_Modificar() {
        $queryBodegaModificar = "UPDATE bodega SET Ubicacion = '$this->bodega_ubicacion', Descripcion_Bod = '$this->bodega_descripcion'
                                WHERE Bodega_ID = $this->bodega_id";
        db_connect();
        $validador = mysql_query($queryBodegaModificar);
        db_close();

        if ($validador) {
            $return = true;
        } else {
            $return = false;
        }
        return $return;
    }

    function Bod_Ver($opcion) {
        /* El OPTION es para saber si queremos ver el LISTADO de bodegas o SOLO UNA bodega.
         * true = SOLO UNA
         * false = LISTADO
         */
        if ($opcion == false) {
            $queryBodegaVer = "SELECT Bodega_ID, Ubicacion, Descripcion_Bod FROM bodega ORDER BY Bodega_ID;";
        } else {
            $queryBodegaVer = "SELECT Bodega_ID, Ubicacion, Descripcion_Bod FROM bodega WHERE Bodega_ID = $this->bodega_id;";
        }

        db_connect();

        $resultset = mysql_query($queryBodegaVer);

        if ($resultset == false) {
            $return = false;
        } else {
            $contador_array = 0;

            while ($row = mysql_fetch_array($resultset)) {
                $bodega[$contador_array][0] = $row["Bodega_ID"];
                $bodega[$contador_array][1] = $row["Ubicacion"];
                $bodega[$contador_array][2] = $row["Descripcion_Bod"];
                $contador_array++;
            }
            $return = $bodega;
        }
        db_close();
        return $return;
    }

//    function Bod_Eliminar() {
//        $queryExiste = "SELECT * FROM bodega";
//
//        db_connect();
//
//        $resultset = mysql_query($queryExiste);
//        $existe = mysql_num_rows($resultset);
//
//        if ($existe <= 1) {
//            //No se puede eliminar la bodega porque solo existe una bodega
//            $return = false;
//        } else {
//            $queryExisteStock = "SELECT * FROM contiene WHERE Bodega_ID = $this->bodega_id AND Stock > 0";
//            $exSt = mysql_query($queryExisteStock);
//            $existeStock = mysql_num_rows($exSt);
//            if ($existeStock > 0) {
//                //No se puede eliminar bodega porque existe stock
//                $return = false;
//            } else {
//                $queryEliminar = "DELETE FROM bodega WHERE Bodega_ID = $this->bodega_id";
//                if (mysql_query($queryEliminar)) {
//                    $return = true;
//                } else {
//                    $return = false;
//                }
//            }
//        }
//        db_close();
//        return $return;
//    }

}
