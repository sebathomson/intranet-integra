<?php

require_once (PATH_ROOT . '/controlador/functions/db_connect.php');
require_once (PATH_ROOT . '/modelo/obra.php');
require_once (PATH_ROOT . '/modelo/lineadeventa.php');
require_once (PATH_ROOT . '/modelo/stockbodega.php');

class LineaDeVentaObra extends LineaDeVenta {

    var $lineaVtaObra_ID;
    var $lineaVtaObra_bodega_id;
    var $lineaVtaObra_material_id;
    var $lineaVtaObra_rut_empleado;
    var $lineaVtaObra_cantidad;

    function __construct($v_venta_id, $v_bodega_id, $v_material_id, $v_rut_empleado, $v_cantidad) {
        $this->lineaVtaObra_ID = $v_venta_id;
        $this->lineaVtaObra_bodega_id = $v_bodega_id;
        $this->lineaVtaObra_material_id = $v_material_id;
        $this->lineaVtaObra_rut_empleado = $v_rut_empleado;
        $this->lineaVtaObra_cantidad = $v_cantidad;
    }

    function LineaVta_Nueva() {
        $registro = new StockBodega($this->lineaVtaObra_cantidad, 0, $this->lineaVtaObra_rut_empleado, $this->lineaVtaObra_material_id, $this->lineaVtaObra_bodega_id);
        $registro->Stock_Quitar();
        if ($registro) {
            $queryLineaVta = "INSERT INTO egreso_material_obra (Bodega_ID, Material_ID, Obra_ID, Rut_Emp, Fecha, Cantidad) 
            VALUES ($this->lineaVtaObra_bodega_id, $this->lineaVtaObra_material_id, $this->lineaVtaObra_ID, '$this->lineaVtaObra_rut_empleado', CURRENT_TIMESTAMP, $this->lineaVtaObra_cantidad)";
            db_connect();
            
            $validar = mysql_query($queryLineaVta);
            
            if ($validar) {
                $return = true;
            } else {
                $return = false;
            }
            db_close();
        }
        return $return;
    }

}

?>