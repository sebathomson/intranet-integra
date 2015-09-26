<?php

require_once (PATH_ROOT . '/controlador/functions/db_connect.php');

//require_once ('lineadeventainsumo.php'); 

class Venta {

    var $venta_ID;
    var $venta_rut_cliente;
    var $venta_rut_vendedor;

    function __construct($v_venta_ID, $v_venta_rut_cliente, $v_venta_rut_vendedor) {
        $this->venta_ID = $v_venta_ID;
        $this->venta_rut_cliente = $v_venta_rut_cliente;
        $this->venta_rut_vendedor = $v_venta_rut_vendedor;
    }

    function Vta_Nueva() {
        db_connect();

        $queryVta = "INSERT INTO venta_de_material (Rut_Cli, Rut_Emp, Fecha)
                            VALUES ('$this->venta_rut_cliente', '$this->venta_rut_vendedor', CURRENT_TIMESTAMP)";


        if (mysql_query($queryVta)) {
            $ventaID = mysql_insert_id();
        } else {
            $ventaID = false;
        }

        db_close();
        return $ventaID; 
        //se devuelve el ID de la venta recien creada, para luego mandarla desde la 
        //vista o controlador al lineadeventainsumo.php
    }

    function Vta_buscar($estadistica) {
/*
 * VENTA DE INSUMOS 
 */
        $insumos = array();
        db_connect();
        for($meses = 1; $meses < 13; $meses++){
            
            $queryBuscar = "SELECT COUNT(*) AS CANTIDAD FROM venta_de_material WHERE MONTH(fecha) = $meses AND YEAR(fecha) = $estadistica";
            $resultBuscar = mysql_query($queryBuscar);
            
            while ($row = mysql_fetch_array($resultBuscar)) {
                
            $insumos['insumos'][$meses] = $row['CANTIDAD'];
                
            }
            
        }
/*
 * VENTA DE SERVICIOS
 */
        for($meses = 1; $meses < 13; $meses++){
            
            $queryBuscar = "SELECT COUNT(*) AS CANTIDAD FROM venta_de_servicio WHERE MONTH(fecha) = $meses AND YEAR(fecha) = $estadistica";
            $resultBuscar = mysql_query($queryBuscar);
            
            while ($row = mysql_fetch_array($resultBuscar)) {
                
            $insumos['servicios'][$meses] = $row['CANTIDAD'];
                
            }
            
        }
        db_close();
        return $insumos;
    }

}

?>