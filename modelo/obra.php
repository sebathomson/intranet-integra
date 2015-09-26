<?php

require_once (PATH_ROOT . '/controlador/functions/db_connect.php');

require_once (PATH_ROOT . '/modelo/material.php');

class Obra {

    var $obra_id;
    var $obra_nombre;
    var $obra_descripcion;
    var $obra_estado;
    var $obra_id_servicio;

    function __construct($v_obra_id, $v_obra_nombre, $v_obra_descripcion, $v_obra_estado, $v_obra_id_servicio) {
        $this->obra_id = $v_obra_id;
        $this->obra_nombre = $v_obra_nombre;
        $this->obra_descripcion = $v_obra_descripcion;
        $this->obra_estado = $v_obra_estado;
        $this->obra_id_servicio = $v_obra_id_servicio;
    }

    function Obra_Valid_ID() {

        $queryValid = "SELECT COUNT(OBRA_ID)FROM obra WHERE OBRA_ID = $this->obra_id;";
        db_connect();

        $resultado = mysql_query($queryValid);
        
       $return = mysql_result($resultado, 0);

        db_close();
        return $return;
    }

    function Obra_Nueva() {

        $queryObraNueva = "INSERT INTO obra (SERVICIO_ID, DESCRIPCION_OBR, NOMBRE_OBR, FECHA_INI)
		VALUES($this->obra_id_servicio,'$this->obra_descripcion','$this->obra_nombre',CURRENT_TIMESTAMP);";

        db_connect();
        mysql_query($queryObraNueva);

        $validador = mysql_affected_rows();

        $this->obra_id = MYSQL_INSERT_ID();

        db_close();

        if ($validador !== 0) {
            $return = $this->obra_id;
        } else {
            $return = false;
        }
        return $return;
    }

    function Obra_Modificar() {

        $validar = $this->Obra_Valid_ID();

        if ($validar == 1) {

            if ($this->obra_estado == "Finalizada") {
                $this->obra_estado = 1;
            } else {
                $this->obra_estado = 0;
            }

            $queryObraModificar = "UPDATE obra SET DESCRIPCION_OBR = '$this->obra_descripcion', NOMBRE_OBR = '$this->obra_nombre', ESTADO = $this->obra_estado WHERE OBRA_ID = $this->obra_id;";

            db_connect();
            mysql_query($queryObraModificar);
            $validador = mysql_affected_rows();

            db_close();
            if ($validador !== 0) {
                $return = true;
            } else {
                $return = false;
            }
        } else {
            $return = false;
        }
        return $return;
    }

    function Obra_Ver() {

        $validar = $this->Obra_Valid_ID();

        $obra = array();
        $obra[0] = $this->obra_id;

        if ($validar == 1) {
            db_connect();

            $queryObraVer = "SELECT NOMBRE_OBR, DESCRIPCION_OBR, SERVICIO_ID, FECHA_INI, ESTADO FROM obra WHERE OBRA_ID = $this->obra_id;";
            $resulset = db_query_resulset($queryObraVer);
            $obra[0] = $this->obra_id; // ID de la Obra
            $obra[1] = mysql_result($resulset, 0, 0); // Nombre
            $obra[2] = mysql_result($resulset, 0, 1); // Descripcion
            $obra[3] = mysql_result($resulset, 0, 2); // ID del Servicio
            $obra[4] = mysql_result($resulset, 0, 3); // Fecha inicio
            $this->obra_estado = mysql_result($resulset, 0, 4); // Estado

            if ($this->obra_estado == 0) {
                $obra[5] = "En Curso";
            } else {
                $obra[5] = "Finalizada";
            }

            $queryServicio = "SELECT RUT_CLI FROM venta_de_servicio WHERE SERVICIO_ID = $obra[3]";
            $resulsetServicio = db_query_resulset($queryServicio);
            $rut_cliente = mysql_result($resulsetServicio, 0);
            $obra[10] = $rut_cliente;

            $queryCliente = "SELECT NOMBRE_CLI FROM cliente WHERE RUT_CLI = '$rut_cliente';";
            $resulsetCliente = db_query_resulset($queryCliente);
            $obra[6] = mysql_result($resulsetCliente, 0); // Nombre del Cliente
            /*
             * Los empleados que trabajan en la obra como OBREROS (PRIRORIDAD = 0).
             * Los empleados que trabajan en la obra como SUPERVISORES (PRIRORIDAD = 1).
             */
            $queryEmpleados = "SELECT RUT_EMP FROM empleado_de_obra WHERE PRIORIDAD = 0 AND ACTIVACION = 1 AND OBRA_ID = $this->obra_id;";
            $resulsetEmpleados = db_query_resulset($queryEmpleados);
            $obra_obreros = array();
            $contador = 0;
            while ($row = @mysql_fetch_array($resulsetEmpleados)) {
                $rut_empleado = $row["RUT_EMP"];
                $queryTemp = "SELECT Nombre_Emp From empleado WHERE Rut_Emp = '$rut_empleado'";
                $nombreObr = mysql_query($queryTemp);
                $cont = 0;
                while ($row2 = mysql_fetch_array($nombreObr)) {
                    $nom = $row2["Nombre_Emp"];
                    $cont++;
                }
                $obra_obreros[$contador] = $nom;
                $contador++;
            }
            $obra[7] = $obra_obreros; // Obreros
            /*
             * Los empleados que trabajan en la obra como OBREROS (PRIRORIDAD = 0).
             * Los empleados que trabajan en la obra como SUPERVISORES (PRIRORIDAD = 1).
             */
            $querySupervisores = "SELECT RUT_EMP FROM empleado_de_obra WHERE PRIORIDAD = 1 AND ACTIVACION = 1 AND OBRA_ID = $this->obra_id;";
            $resulsetSupervisores = db_query_resulset($querySupervisores);
            $obra_supervisores = array();
            $contador = 0;
            while ($row = @mysql_fetch_array($resulsetSupervisores)) {
                $rut_empleado = $row["RUT_EMP"];
                $queryTemp = "SELECT Nombre_Emp From empleado WHERE Rut_Emp = '$rut_empleado'";
                $nombreSup = mysql_query($queryTemp);
                $cont = 0;
                while ($row2 = mysql_fetch_array($nombreSup)) {
                    $nom = $row2["Nombre_Emp"];
                    $cont++;
                }
                $obra_supervisores[$contador] = $nom;
                $contador++;
            }
            $obra[8] = $obra_supervisores; // Supervisores
            /*
             * MATERIAL UTILIZADO EN OBRA.
             *
             */
            $queryMateriales = "SELECT MATERIAL_ID, CANTIDAD FROM egreso_material_obra WHERE OBRA_ID = $this->obra_id;";
            $resulsetMateriales = db_query_resulset($queryMateriales);
            $obra_materiales = array();
            $contador = 0;
            while ($row = @mysql_fetch_array($resulsetMateriales)) {
                $obra_materiales[$contador][0] = $row["MATERIAL_ID"];
                $obra_materiales[$contador][1] = $row["CANTIDAD"];
                $contador++;
            }
            db_close();

            for ($contador2 = 0; $contador2 < count($obra_materiales); $contador2++) {

                $material_id_aux = $obra_materiales[$contador2][0];

                $instancia_material = new Material($material_id_aux, 0, 0, 0, 0, 0);

                $materiales = $instancia_material->Mat_Ver();

                $obra_materiales[$contador2][2] = $materiales[2]; // Nombre del Material
            }

            $obra[9] = $obra_materiales; // Materiales


            $return = $obra;
        } else {
            $return = false;
        }
        return $return;
    }

    function Obra_Asignar_Empleado($rut_emp, $prioridad, $activacion) {

        $queryExiste = "SELECT Obra_ID FROM empleado_de_obra WHERE Obra_ID = $this->obra_id AND Rut_Emp = '$rut_emp'";

        db_connect();

        $queryExiste = mysql_query($queryExiste);
        $rows = mysql_num_rows($queryExiste);

        if ($rows == 0) {
            $query = "INSERT INTO empleado_de_obra (Fecha, Obra_ID, Rut_Emp, Prioridad, Activacion) 
                VALUES (CURRENT_TIMESTAMP, $this->obra_id, '$rut_emp', $prioridad, $activacion)"; // ACTIVACION DEFAULT = 1

            if (mysql_query($query)) {
                $return = true;
            } else {
                $return = false;
            }
        } else {
            $query = "UPDATE empleado_de_obra
                    SET Activacion = $activacion
                    WHERE Obra_ID = $this->obra_id AND Rut_Emp = '$rut_emp'"; // ACTIVACION DEFAULT = 1
            if (mysql_query($query)) {
                $return = true;
            } else {
                $return = false;
            }
        }

        db_close();
        return $return;
    }

    function Obra_Buscar($filtro, $clave) {
        if ($filtro == "obra_id") {
            $queryObraBuscar = "SELECT Obra_ID, Servicio_ID, Nombre_Obr, Estado
                                    FROM obra
                                    WHERE Obra_ID = $clave";
        }
        if ($filtro == "servicio_id") {
            $queryObraBuscar = "SELECT Obra_ID, Servicio_ID, Nombre_Obr, Estado
                                    FROM obra
                                    WHERE Servicio_ID = $clave";
        }
        if ($filtro == "obra_nombre") {
            $queryObraBuscar = "SELECT Obra_ID, Servicio_ID, Nombre_Obr, Estado
                                    FROM obra
                                    WHERE Nombre_Obr LIKE '%$clave%'";
        }
        $resultObra = array();
        db_connect();

        $rowObra = mysql_query($queryObraBuscar);

        if (!$rowObra) {
            $return = false;
        } else {
            $contador = 0;
            While ($row = mysql_fetch_array($rowObra)) {
                $resultObra[$contador][0] = $row["Obra_ID"];
                $resultObra[$contador][1] = $row["Servicio_ID"];
                $resultObra[$contador][2] = $row["Nombre_Obr"];
                $this->obra_estado = $row["Estado"];

                if ($this->obra_estado == 0) {
                    $resultObra[$contador][3] = "En Curso";
                } else {
                    $resultObra[$contador][3] = "Finalizada";
                }

                $contador++;
            }
            $return = $resultObra;
        }
        db_close();
        return $return;
    }

}

?>