<?php

require_once (PATH_ROOT . '/modelo/stockbodega.php');
require_once (PATH_ROOT . '/controlador/functions/db_connect.php');

class LineaDeVenta {

    var $lineaVta_bodega_id;
    var $lineaVta_cantidad;
    var $lineaVta_material_id;
    var $lineaVta_fecha;

    function LineaDeVenta($v_bodega_id, $v_cantidad, $v_registro, $v_fecha) {
        $this->lineaVta_bodega_id = $v_bodega_id;
        $this->lineaVta_cantidad = $v_cantidad;
        $this->lineaVta_material_id = $v_registro;
        $this->lineaVta_fecha = $v_fecha;
    }

    function LineaVta_Nueva() {
        
    }

    function LineaDeVenta_Buscar($busqueda) {
    }

}

?>