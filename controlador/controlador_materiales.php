<?php

require_once ("controlador_principal.php");

require_once (PATH_ROOT . '/modelo/stockbodega.php');
require_once (PATH_ROOT . '/modelo/bodega.php');
require_once (PATH_ROOT . '/modelo/material.php');
require_once (PATH_ROOT . '/controlador/functions/validar.php');

class controlador_materiales {

//FUNCIONES
    function material_ver($material_identificacion) {
        $material = array();

        if (validarID($material_identificacion)) {

            $material_instancia = new Material($material_identificacion, 0, 0, 0, 0, 0);

            $material = $material_instancia->Mat_Ver();

            return $material;
        } else {
            return false;
        }
    }

    function material_buscar($busqueda, $filtro) {
        $material = array();

        if ($filtro == "material_nombre"
                OR $filtro == "material_categoria"
                OR $filtro == "material_id"
                OR $filtro == "material_bodega") {
            
        } else {
            return false;
        }

        $material_instancia = new Material(0, 0, 0, 0, 0, 0);

        $material = $material_instancia->Mat_Buscar($filtro, $busqueda);

        if ($material == false) {
            return false;
        } else {
            return $material;
        }
    }

    function getCategoria() {
        $categoria = array();
        $material_instancia = new Material(0, 0, 0, 0, 0, 0);
        $categoria = $material_instancia->getCategoria();
        return $categoria;
    }

    function material_modificar() {
        $material_id = $_POST["material_id"];
        if (empty($_POST["material_descripcion"])
                OR empty($_POST["material_categoria"])) {
            header("Location: ../vista/bodega/materiales.php?seccion=ver&id=$material_id&mensaje=modificarError");
        } else {
            $material_descripcion = $_POST["material_descripcion"];
            $material_categoria = $_POST["material_categoria"];

            if (validarDescripcion($material_descripcion)
                    AND validarID($material_categoria)
            ) {
                $instancia_material = new Material($material_id, 0, 0, $material_descripcion, 0, 0);

                $material_validacion_modificar = $instancia_material->Mat_Modificar($material_categoria);

                if ($material_validacion_modificar == false) {
                    header("Location: ../vista/bodega/materiales.php?seccion=ver&id=$material_id&mensaje=modificarError");
                } else {
                    if ($_FILES['imagen']['size'] <= 500000) {
                        $nombre_archivo_imagen = "";
                        switch ($_FILES['imagen']['type']) {
                            case "image/jpg":
                                $nombre_archivo_imagen = "mat_" . $material_id . ".jpg";
                                break;
                            case "image/jpeg":
                                $nombre_archivo_imagen = "mat_" . $material_id . ".jpg";
                                break;
                            case "image/gif":
                                $nombre_archivo_imagen = "mat_" . $material_id . ".gif";
                                break;
                            case "image/png":
                                $nombre_archivo_imagen = "mat_" . $material_id . ".png";
                                break;
                            default:
                                $nombre_archivo_imagen = false;
                                break;
                        }

                        if ($nombre_archivo_imagen == false) {
                            
                        } else {
                            require_once (PATH_ROOT . '/controlador/functions/class_imgUpldr.php');
                            $subir = new imgUpldr;
                            $subir->_dest = PATH_ROOT . '/vista/images/productos-images/';
                            $subir->_name = $nombre_archivo_imagen;
                            $subir->init($_FILES['imagen']);

                            if (file_exists(PATH_ROOT . '/vista/images/productos-images/' . $nombre_archivo_imagen)) {
//                                $instancia_material_img = new Material($material_id, 0, 0, 0, $nombre_archivo_imagen, 0);
//                                $instancia_material_img->Mat_Modificar_imagen();

                                $instancia_material->material_img_referencial = $nombre_archivo_imagen;
                                $instancia_material->Mat_Modificar_imagen();
                            }
                        }
                    }
                    header("Location: ../vista/bodega/materiales.php?seccion=ver&id=$material_id&mensaje=modificarOk");
                }
            } else {
                header("Location: ../vista/bodega/materiales.php?seccion=ver&id=$material_id&mensaje=modificarError");
            }
        }
    }

    function material_crear() {
        if (empty($_POST["material_nombre"])
                OR empty($_POST["material_descripcion"])
                OR $_POST["material_proveedor"] == "no_option"
                OR $_POST["material_categoria"] == "no_option") {
            header("Location: ../vista/bodega/materiales.php?seccion=crear&mensaje=crearError");
        } else {
            $material_nombre = $_POST["material_nombre"];
            $material_descripcion = $_POST["material_descripcion"];
            $material_proveedor = $_POST["material_proveedor"];
            $material_categoria = $_POST["material_categoria"];

            if (validarMaterialNombre($material_nombre)
                    AND validarDescripcion($material_descripcion)
                    AND validarID($material_categoria)
                    AND validarRut($material_proveedor)
            ) {
                $instacia_usuario = new Usuario($_SESSION["session_username"], 0, 0, 0, 0);
                $rut_usuario = $instacia_usuario->User_getRut();

                $instancia_material = new Material(0, $material_nombre, $material_categoria, $material_descripcion, 0, $material_proveedor);
                $material_ultimo_id = $instancia_material->Mat_Nuevo($rut_usuario);

                $bodega_array = array();

                $instanciasBodega = new Bodega(0, 0, 0);
                $bodega_array = $instanciasBodega->Bod_Ver(false);

                for ($count = 0; $count < count($bodega_array); $count++) {
                    $instanciasStockBodega = new StockBodega(0, 0, 0, $material_ultimo_id, $bodega_array[$count][0]);
                    $instanciasStockBodega->Stock_Agregar();
                    unset($instanciasStockBodega);
                }

                if ($material_ultimo_id == false) {
                    header("Location: ../vista/bodega/materiales.php?seccion=crear&mensaje=crearError");
                } else {
                    if ($_FILES['imagen']['size'] <= 500000) {
                        $nombre_archivo_imagen = "";
                        switch ($_FILES['imagen']['type']) {
                            case "image/jpg":
                                $nombre_archivo_imagen = "mat_" . $material_ultimo_id . ".jpg";
                                break;
                            case "image/jpeg":
                                $nombre_archivo_imagen = "mat_" . $material_ultimo_id . ".jpg";
                                break;
                            case "image/gif":
                                $nombre_archivo_imagen = "mat_" . $material_ultimo_id . ".gif";
                                break;
                            case "image/png":
                                $nombre_archivo_imagen = "mat_" . $material_ultimo_id . ".png";
                                break;
                            default:
                                $nombre_archivo_imagen = false;
                                break;
                        }

                        if ($nombre_archivo_imagen == false) {
                            
                        } else {
                            require_once (PATH_ROOT . '/controlador/functions/class_imgUpldr.php');
                            $subir = new imgUpldr;
                            $subir->_dest = PATH_ROOT . '/vista/images/productos-images/';
                            $subir->_name = $nombre_archivo_imagen;
                            $subir->init($_FILES['imagen']);

                            if (file_exists(PATH_ROOT . '/vista/images/productos-images/' . $nombre_archivo_imagen)) {
//                                $instancia_material_img = new Material($material_id, 0, 0, 0, $nombre_archivo_imagen, 0);
//                                $instancia_material_img->Mat_Modificar_imagen();

                                $instancia_material->material_img_referencial = $nombre_archivo_imagen;
                                $instancia_material->Mat_Modificar_imagen();
                            }
                        }
                    }
                    header("Location: ../vista/bodega/materiales.php?seccion=ver&id=$material_ultimo_id&mensaje=crearOk");
                }
            } else {
                header("Location: ../vista/bodega/materiales.php?seccion=crear&mensaje=crearError");
            }
        }
    }

}

$instancia_controlador_materiales = new controlador_materiales();
//Switch-Case
if (isset($_GET["accion"])) {
    $accion = $_GET["accion"];
    switch ($accion) {
        case "modificar":
            $instancia_controlador_materiales->material_modificar();
            break;
        case "crearmaterial":
            $instancia_controlador_materiales->material_crear();
            break;
    }
}
?>