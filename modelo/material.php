<?php

require_once (PATH_ROOT . '/modelo/proveedor.php');
require_once (PATH_ROOT . '/controlador/functions/db_connect.php');

class Material {

    var $material_id;
    var $material_nombre;
    var $material_categoria;
    var $material_descripcion;
    var $material_img_referencial;
    var $material_rut_proveedor;

    function __construct($v_material_id, $v_material_nombre, $v_material_categoria, $v_material_descripcion, $v_material_img_referencial, $v_material_rut_proveedor) {
        $this->material_id = $v_material_id;
        $this->material_nombre = $v_material_nombre;
        $this->material_categoria = $v_material_categoria;
        $this->material_descripcion = $v_material_descripcion;
        $this->material_img_referencial = $v_material_img_referencial;
        $this->material_rut_proveedor = $v_material_rut_proveedor;
    }

    function Mat_Proveedor($rut_usuario) {
        $queryProveedor = "INSERT INTO ingreso_material_nuevo (Rut_Emp, Material_ID, Rut_Prov, Fecha)
                            VALUES ('$rut_usuario', $this->material_id, '$this->material_rut_proveedor', CURRENT_TIMESTAMP)";
        if (mysql_query($queryProveedor)) {
            $return = true;
        } else {
            $return = false;
        }
        return $return;
    }

    function Mat_Nuevo($rut_usuario) {
        $queryNuevo = "INSERT INTO material (Sub_Cat_ID, Nombre_Mat, Imagen_Mat, DESCRIPCION_MAT)
                            VALUES ($this->material_categoria, '$this->material_nombre', 'no_imagen.jpg', '$this->material_descripcion')";
        db_connect();
        if (mysql_query($queryNuevo)) {
            $ultimoID = mysql_insert_id();

            $instanciaMaterial = new Material($ultimoID, 0, 0, 0, 0, $this->material_rut_proveedor);
            $validadorProveedor = $instanciaMaterial->Mat_Proveedor($rut_usuario);

            if ($validadorProveedor == true) {
                $return = $ultimoID;
            } else {
                $return = false;
            }
        } else {
            $return = false;
        }
        db_close();
        return $return;
    }

    function Mat_Modificar($material_subcategoria) {
        $queryModificar = "UPDATE material 
                                SET Sub_Cat_ID = '$material_subcategoria',
                                    DESCRIPCION_MAT = '$this->material_descripcion'
                                WHERE Material_ID = $this->material_id";
        db_connect();
        if (mysql_query($queryModificar)) {
            $return = true;
        } else {
            $return = false;
        }
        db_close();
        return $return;
    }

    function Mat_Modificar_imagen() {
        $queryModificar = "UPDATE material 
                                SET Imagen_Mat = '$this->material_img_referencial'
                                WHERE Material_ID = $this->material_id";
        db_connect();
        if (mysql_query($queryModificar)) {
            $return = true;
        } else {
            $return = false;
        }
        db_close();
        return $return;
    }

    function Mat_Ver() {
        $material = array();
        $queryVer = "SELECT material.Material_ID, sub_categoria.Nombre_Sub_Cat, material.Nombre_Mat, 
                                material.Imagen_Mat, material.Descripcion_Mat, proveedor.Nombre_Prov 
                            FROM material, ingreso_material_nuevo, proveedor, sub_categoria
                            WHERE sub_categoria.Sub_cat_ID = material.Sub_Cat_ID
                                 AND material.Material_ID = ingreso_material_nuevo.Material_ID 
                                 AND ingreso_material_nuevo.Rut_Prov = proveedor.Rut_Prov
                                 AND material.Material_ID = $this->material_id";
        db_connect();
        $ver = mysql_query($queryVer);
        while ($row = mysql_fetch_array($ver)) {
            $material[0] = $row["Material_ID"];
            $material[1] = $row["Nombre_Sub_Cat"];
            $material[2] = $row["Nombre_Mat"];
            $material[3] = $row["Imagen_Mat"];
            $material[4] = $row["Descripcion_Mat"];
            $material[5] = $row["Nombre_Prov"];
        }
        db_close();
        return $material;
    }

    function Mat_Buscar($filtro, $clave) {

        if ($filtro == "material_nombre") {
            $queryMaterialBuscar = "SELECT material.Material_ID, material.Nombre_Mat, categoria.Nombre_Cat, 
                                         sub_categoria.Nombre_Sub_Cat, contiene.Bodega_ID, contiene.Stock 
                                FROM material, categoria, sub_categoria, ingreso_material_nuevo, contiene
                                Where categoria.Categoria_ID = sub_categoria.Categoria_ID
                                        AND sub_categoria.Sub_Cat_ID = material.Sub_Cat_ID
                                        AND material.Material_ID = ingreso_material_nuevo.Material_ID
                                        AND material.Material_ID = contiene.Material_ID                                        
                                        AND material.Nombre_Mat LIKE '%$clave%'
                                GROUP BY contiene.Bodega_ID, material.Material_ID
                                ORDER BY material.Material_ID";
        }

        if ($filtro == "material_id") {
            $queryMaterialBuscar = "SELECT material.Material_ID, material.Nombre_Mat, categoria.Nombre_Cat, 
                                         sub_categoria.Nombre_Sub_Cat, contiene.Bodega_ID, contiene.Stock 
                                FROM material, categoria, sub_categoria, ingreso_material_nuevo, contiene
                                Where categoria.Categoria_ID = sub_categoria.Categoria_ID
                                        AND sub_categoria.Sub_Cat_ID = material.Sub_Cat_ID
                                        AND material.Material_ID = ingreso_material_nuevo.Material_ID
                                        AND material.Material_ID = contiene.Material_ID                                        
                                        AND material.Material_ID LIKE '%$clave%'
                                GROUP BY contiene.Bodega_ID, material.Material_ID
                                ORDER BY material.Material_ID";
        }
        /*
         * La busqueda por categoría DEBE ser por la SUB-CATEGORÍA.
         */
        if ($filtro == "material_categoria") {
            $queryMaterialBuscar = "SELECT material.Material_ID, material.Nombre_Mat, categoria.Nombre_Cat, 
                                            sub_categoria.Nombre_Sub_Cat, contiene.Bodega_ID, contiene.Stock 
                                    FROM material, categoria, sub_categoria, ingreso_material_nuevo, contiene
                                    Where categoria.Categoria_ID = sub_categoria.Categoria_ID
                                        AND sub_categoria.Sub_Cat_ID = material.Sub_Cat_ID
                                        AND material.Material_ID = ingreso_material_nuevo.Material_ID
                                        AND material.Material_ID = contiene.Material_ID                                        
                                        AND categoria.Nombre_Cat LIKE '%$clave%'
                                    GROUP BY contiene.Bodega_ID, material.Material_ID
                                    ORDER BY material.Material_ID";
        }

        if ($filtro == "material_bodega") {
            $queryMaterialBuscar = "SELECT material.Material_ID, material.Nombre_Mat, categoria.Nombre_Cat, 
                                         sub_categoria.Nombre_Sub_Cat, contiene.Bodega_ID, contiene.Stock 
                                    FROM material, categoria, sub_categoria, ingreso_material_nuevo, contiene
                                    Where categoria.Categoria_ID = sub_categoria.Categoria_ID
                                        AND sub_categoria.Sub_Cat_ID = material.Sub_Cat_ID
                                        AND material.Material_ID = ingreso_material_nuevo.Material_ID
                                        AND material.Material_ID = contiene.Material_ID                                        
                                        AND contiene.Bodega_ID = $clave
                                    GROUP BY contiene.Bodega_ID, material.Material_ID
                                    ORDER BY material.Material_ID";
        }
        $material = array();

        db_connect();

        $buscar = mysql_query($queryMaterialBuscar);

        $contador = 0;

        while ($row = mysql_fetch_array($buscar)) {
            $material[$contador][0] = $row["Material_ID"]; // ID del material
            $material[$contador][1] = $row["Nombre_Mat"]; // nombre del material                
            $material[$contador][2] = $row["Nombre_Cat"] . " - " . $row["Nombre_Sub_Cat"]; // Categoria - Sub categoria
            $material[$contador][3] = $row["Bodega_ID"]; //Id de la bodega
            $material[$contador][4] = $row["Stock"]; //Stock
            $contador++;
        }

        db_close();

        return $material;
    }

    function getCategoria() {
        $categoria = array();
        $subCategoria = array();
        
        $queryCat = "SELECT Nombre_Cat, Categoria_ID
                            FROM Categoria";
        
        db_connect();
        
        $resultsetcat = mysql_query($queryCat);
        $contador1 = 0;
        while ($row1 = mysql_fetch_array($resultsetcat)) {
            $catID = $row1["Categoria_ID"];
            $querySubCat = "SELECT sub_categoria.Nombre_Sub_Cat, sub_categoria.Sub_Cat_ID
                                    FROM categoria, sub_categoria
                                    WHERE categoria.Categoria_ID = sub_categoria.Categoria_ID
                                        AND categoria.Categoria_ID = $catID";
            $resultsetsubCat = mysql_query($querySubCat);
            $contador2 = 0;
            while ($row2 = mysql_fetch_array($resultsetsubCat)) {
                $subCategoria[$contador2][0] = $row2["Sub_Cat_ID"];
                $subCategoria[$contador2][1] = $row2["Nombre_Sub_Cat"];
                $contador2++;
            }
            $categoria[$contador1][0] = $row1["Categoria_ID"];
            $categoria[$contador1][1] = $row1["Nombre_Cat"];
            $categoria[$contador1][2] = $subCategoria;
            $contador1++;
        }
        db_close();
        return $categoria;
    }

}

?>