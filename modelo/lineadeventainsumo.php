<?php

require_once (PATH_ROOT . '/modelo/lineadeventa.php');
require_once (PATH_ROOT . '/modelo/stockbodega.php');
require_once (PATH_ROOT . '/modelo/material.php');
require_once (PATH_ROOT . '/controlador/functions/db_connect.php');

class LineaDeVentaInsumo extends LineaDeVenta {

    var $lineaVtaInsumo_ID;
    var $lineaVtaInsumo_bodega_id;
    var $lineaVtaInsumo_material_id;
    var $lineaVtaInsumo_rut_empleado;
    var $lineaVtaInsumo_cantidad;

    function __construct($v_venta_id, $v_bodega_id, $v_material_id, $v_rut_empleado, $v_cantidad) {
        $this->lineaVtaInsumo_ID = $v_venta_id;
        $this->lineaVtaInsumo_bodega_id = $v_bodega_id;
        $this->lineaVtaInsumo_material_id = $v_material_id;
        $this->lineaVtaInsumo_rut_empleado = $v_rut_empleado;
        $this->lineaVtaInsumo_cantidad = $v_cantidad;
    }

    function LineaVta_Nueva() {

        $instanciaStockBodega = new StockBodega($this->lineaVtaInsumo_cantidad, 0, $this->lineaVtaInsumo_rut_empleado, $this->lineaVtaInsumo_material_id, $this->lineaVtaInsumo_bodega_id);
        $ValidarQuitar = $instanciaStockBodega->Stock_Quitar();

        db_connect();

        if ($ValidarQuitar) {
            $queryLinea = "INSERT INTO egreso_material_venta (Bodega_ID, Material_ID, Rut_Emp, Venta_Material_ID, Fecha, Cantidad)
                                    VALUES ($this->lineaVtaInsumo_bodega_id, $this->lineaVtaInsumo_material_id, '$this->lineaVtaInsumo_rut_empleado', $this->lineaVtaInsumo_ID, CURRENT_TIMESTAMP, $this->lineaVtaInsumo_cantidad)";
            if (mysql_query($queryLinea)) {
                $return = true;
            } else {
                $return = false;
            }
        }
        db_close();
        return $return;
    }

    function LineaDeVenta_Buscar($busqueda) {
        $query = "SELECT * FROM venta_de_material WHERE rut_cli = '$busqueda';";
        db_connect();
        $resulsetRut = mysql_query($query);
        $contador = 0;
        $egresos = array();
        while ($rowRut = mysql_fetch_array($resulsetRut)) {
            $vta_id = $rowRut["VENTA_MATERIAL_ID"];
            $egresos[$contador][0] = $vta_id;
            $egresos[$contador][1] = $rowRut["RUT_CLI"];
            $egresos[$contador][2] = $rowRut["FECHA"];
            $contador++;
        }
        $egresos_cont = array();
        for ($count = 0; count($egresos) > $count; $count++) {
            $vta_id = $egresos[$count][0];
            $query_egreso = "SELECT * FROM egreso_material_venta WHERE venta_material_id = $vta_id";
            $resulset_egreso = mysql_query($query_egreso);
            $contadors = 0;
            while ($rowRuts = mysql_fetch_array($resulset_egreso)) {
                $egresos_cont[$contadors][2] = $rowRuts["MATERIAL_ID"];
                $egresos_cont[$contadors][1] = $rowRuts["CANTIDAD"];
                $contadors++;
            }
        }
        db_close();
        for ($counts = 0; count($egresos_cont) > $counts; $counts++) {
            $material_id = $egresos_cont[$counts][2];
            $instancia_material = new Material($material_id, 0, 0, 0, 0, 0);
            $material = array();
            $material = $instancia_material->Mat_Ver();
            $egresos_cont[$counts][0] = $material[2];
        }
        $return = array();
        $return[0] = $egresos;
        $return[1] = $egresos_cont;
        return $return;
    }

}

?>