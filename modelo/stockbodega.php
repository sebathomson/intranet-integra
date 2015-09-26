<?php

require_once (PATH_ROOT . '/controlador/functions/db_connect.php');

class StockBodega {

    var $stockBodega_stock;
    var $stockBodega_fecha;
    var $stockBodega_bodeguero; /* RUT EMPLEADO */
    var $stockBodega_material_id;
    var $stockBodega_bodega_id;

    function __construct($v_stockBodega_stock, $v_stockBodega_fecha, $v_stockBodega_rut_empleado, $v_stockBodega_material_id, $v_stockBodega_bodega_id) {
        $this->stockBodega_stock = $v_stockBodega_stock;
        $this->stockBodega_fecha = $v_stockBodega_fecha;
        $this->stockBodega_bodeguero = $v_stockBodega_rut_empleado;
        $this->stockBodega_material_id = $v_stockBodega_material_id;
        $this->stockBodega_bodega_id = $v_stockBodega_bodega_id;
    }

    function Stock_Ver_Todo() {

        $count = 0;
        $materiales = array();

        db_connect();
        $queryCount = "SELECT COUNT(Material_ID) AS Cantidad FROM contiene Where Stock > 0;";
        $resultCount = mysql_query($queryCount);

        while ($rowCount = mysql_fetch_array($resultCount)) {
            $count = $rowCount["Cantidad"];
        }
        mysql_free_result($resultCount);
        if ($count == 0) {
            return false;
        } else {
            /* 0 = id
             * 1 = categoria
             * 2 = nombre
             * 3 = stock
             * 4 = bodega
             *  */
            $queryMaterialesConStock = "SELECT Material_ID, Bodega_ID, Stock from contiene WHERE Stock > 0 ORDER BY Material_ID ASC";
            $resultMaterialesConStock = mysql_query($queryMaterialesConStock);
            $contador_auxiliar = 0;

            while ($rowIDNombre = mysql_fetch_array($resultMaterialesConStock)) {
                $material_id = $rowIDNombre["Material_ID"];
                $materiales[$contador_auxiliar][3] = $rowIDNombre["Stock"];
                $materiales[$contador_auxiliar][4] = $rowIDNombre["Bodega_ID"];
                $materiales[$contador_auxiliar][0] = $material_id;

                $queryIDNombre = "SELECT Nombre_Mat from material WHERE Material_ID = $material_id";
                $resultIDNombre = mysql_query($queryIDNombre);

                while ($rowIDNombre = mysql_fetch_array($resultIDNombre)) {
                    $materiales[$contador_auxiliar][2] = $rowIDNombre["Nombre_Mat"];
                }
//
                $queryCategoria = "SELECT Nombre_Cat FROM categoria, sub_categoria, material 
                                    WHERE material.Material_ID = $material_id
                                    AND material.Sub_Cat_ID = sub_categoria.Sub_Cat_ID 
                                    AND sub_categoria.Categoria_ID = categoria.Categoria_ID";
                $resultCategoria = mysql_query($queryCategoria);

                while ($row = mysql_fetch_array($resultCategoria)) {
                    $materiales[$contador_auxiliar][1] = $row["Nombre_Cat"];
                }
                $contador_auxiliar++;
            }
            db_close();
            return $materiales;
        }
    }

    function Stock_Agregar() {
        $queryExiste = "SELECT Stock FROM Contiene 
                                WHERE Bodega_ID = $this->stockBodega_bodega_id AND Material_ID = $this->stockBodega_material_id";

        db_connect();
        $existe = mysql_query($queryExiste);
        $validar = mysql_num_rows($existe);

        if ($validar == 1) {// Si existe Stock de ESE material en ESA bodega
            $queryAgregar = "UPDATE Contiene SET Stock = Stock + $this->stockBodega_stock 
                                WHERE Bodega_ID = $this->stockBodega_bodega_id AND Material_ID = $this->stockBodega_material_id";

            if (mysql_query($queryAgregar)) {
                $return = true;
            } else {
                $return = false;
            }
        } else {// No existe Stock de ESE material en ESA bodega
            $queryAgregar = "INSERT INTO Contiene VALUES($this->stockBodega_bodega_id, $this->stockBodega_material_id, $this->stockBodega_stock)";
            if (mysql_query($queryAgregar)) {
                $return = true;
            } else {
                $return = false;
            }
        }
        return $return;
        db_close();
    }

    function Stock_Ver() {
        $verStock = Array();
        $queryStockMinimo = "SELECT Material_ID FROM contiene Where Material_ID=$this->stockBodega_material_id AND Stock > 0";
        db_connect();
        $stockMinimo = mysql_query($queryStockMinimo);
        $row = mysql_num_rows($stockMinimo);

        if ($row == 1) {
            $nombreMaterial = "SELECT Nombre_Mat FROM material WHERE Material_ID=$this->stockBodega_material_id";
            $stockMaterial = "SELECT Stock FROM contiene WHERE Material_ID=$this->stockBodega_material_id";
            $categoriaMaterial = "SELECT Nombre_Cat FROM categoria, sub_categoria, material 
                                    WHERE material.Material_ID=$this->stockBodega_material_id 
                                          AND material.Sub_Cat_ID=sub_categoria.Sub_Cat_ID 
                                          AND sub_categoria.Categoria_ID=categoria.Categoria_ID";
            $nombre = mysql_query($nombreMaterial);
            $categoria = mysql_query($categoriaMaterial);
            $stock = mysql_query($stockMaterial);
            $verStock[0] = $this->stockBodega_material_id; // ID del material
            while ($rows = mysql_fetch_array($categoria)) {
                $verStock[1] = $rows["Nombre_Cat"]; // Categoria del Material
            }
            while ($rows = mysql_fetch_array($nombre)) {
                $verStock[2] = $rows["Nombre_Mat"]; // Nombre del material
            }
            while ($rows = mysql_fetch_array($stock)) {
                $verStock[3] = $rows["Stock"]; // Stock del material
            }
            db_close();
            return $verStock;
        } else {
            db_close();
            return false;
        }
    }

    function Stock_Quitar() {
        db_connect();

        $queryValidar = "SELECT Stock FROM contiene 
                                WHERE Bodega_ID = $this->stockBodega_bodega_id AND Material_ID = $this->stockBodega_material_id";

        $validar = mysql_query($queryValidar);

        while ($row = mysql_fetch_array($validar)) {
            $stock = $row["Stock"];
        }
        //Veo si existe el stock suficiente para realizar el descuento
        if (($stock - $this->stockBodega_stock) >= 0) {
            $queryQuitar = "UPDATE Contiene Set Stock = Stock - $this->stockBodega_stock WHERE Bodega_ID = $this->stockBodega_bodega_id AND Material_ID = $this->stockBodega_material_id";
            $valid = mysql_query($queryQuitar);
            if ($valid) {
                $return = true;
            } else {
                $return = false;
            }
        } else {
            $return = false;
        }
        db_close();
        return $return;
    }

    function Stock_Buscar() {
        $stock = array();
        db_connect();

        $queryStockBuscar = "SELECT Bodega_ID, Stock
                            FROM contiene
                            WHERE Material_ID = $this->stockBodega_material_id";

        $ResultBuscar = mysql_query($queryStockBuscar);
        $contador = 0;
        while ($row = mysql_fetch_array($ResultBuscar)) {
            $stock[$contador][0] = $row["Bodega_ID"];
            $stock[$contador][1] = $row["Stock"];
            $contador++;
        }
        db_close();
        return $stock;
    }

}

?>