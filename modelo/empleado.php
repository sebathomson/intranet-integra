<?php

require_once (PATH_ROOT . '/controlador/functions/db_connect.php');

class Empleado {

    var $empleado_rut;
    var $empleado_nombre;
    var $empleado_apellido_materno;
    var $empleado_apellido_paterno;
    var $empleado_correo;
    var $empleado_direccion;
    var $empleado_fono_fijo;
    var $empleado_fono_movil;
    var $empleado_tipo;

    function __construct($v_rut, $v_nombre, $v_apellido_materno, $v_apellido_paterno, $v_correo, $v_direccion, $v_fono_fijo, $v_fono_movil, $v_tipo) {
        $this->empleado_rut = $v_rut;
        $this->empleado_nombre = $v_nombre;
        $this->empleado_apellido_materno = $v_apellido_materno;
        $this->empleado_apellido_paterno = $v_apellido_paterno;
        $this->empleado_correo = $v_correo;
        $this->empleado_direccion = $v_direccion;
        $this->empleado_fono_fijo = $v_fono_fijo;
        $this->empleado_fono_movil = $v_fono_movil;
        $this->empleado_tipo = $v_tipo;
    }

    function Emp_Nuevo() {
        $queryEmpleadoExiste = "SELECT Rut_Emp FROM empleado WHERE Rut_Emp = '$this->empleado_rut'";

        db_connect();

        $existe = mysql_query($queryEmpleadoExiste);
        $validar = mysql_num_rows($existe);

        if ($validar == 1) {
            $return = false;
        } else {

            $queryTipoEmpleado = "SELECT TIPO_EMP_ID FROM tipo_empleado WHERE NOMBRE_TIPO_EMP = '$this->empleado_tipo';";

            $resultset = mysql_query($queryTipoEmpleado);

            $empleado_tipo_id = mysql_result($resultset, 0);
            $empleado_rut2 = str_replace(".", "", $this->empleado_rut);

            $queryEmpleadoNuevo = "INSERT INTO empleado (Rut_Emp, Nombre_Emp, ApellidoP_Emp, apellidoM_Emp, Correo_Emp, Direccion_Emp, Fono_fijo_Emp, Fono_movil_Emp, Tipo_Emp_ID, Activacion)
                                  VALUES ('$empleado_rut2', '$this->empleado_nombre', '$this->empleado_apellido_paterno', '$this->empleado_apellido_materno', '$this->empleado_correo', '$this->empleado_direccion', '$this->empleado_fono_fijo', '$this->empleado_fono_movil',  $empleado_tipo_id, 1 )";

            if (mysql_query($queryEmpleadoNuevo)) {
                $return = true;
            } else {
                $return = false;
            }
        }
        db_close();
        return $return;
    }

    function Emp_Modificar($empleado_estado) {

        $queryTipoEmpleado = "SELECT TIPO_EMP_ID FROM tipo_empleado WHERE NOMBRE_TIPO_EMP = '$this->empleado_tipo';";

        db_connect();

        $resultset = mysql_query($queryTipoEmpleado);

        $this->empleado_tipo_id = mysql_result($resultset, 0);

        $queryEmpleadoModificar = "UPDATE empleado
                                SET Nombre_Emp = '$this->empleado_nombre', ApellidoP_Emp = '$this->empleado_apellido_paterno', 
                                    ApellidoM_Emp = '$this->empleado_apellido_materno', Correo_Emp = '$this->empleado_correo', 
                                    Direccion_Emp = '$this->empleado_direccion', Fono_fijo_Emp = '$this->empleado_fono_fijo', 
                                    Fono_movil_Emp = '$this->empleado_fono_movil', Tipo_Emp_ID =  $this->empleado_tipo_id, 
                                    Activacion = $empleado_estado
                                WHERE Rut_Emp = '$this->empleado_rut'";

        if (mysql_query($queryEmpleadoModificar)) {
            $return = true;
        } else {
            $return = false;
        }
        db_close();
        return $return;
    }

    function Emp_Ver() {
        $empleado = array();

        $queryEmpleadoVer = "SELECT Rut_Emp, Nombre_Emp, ApellidoP_Emp, 
                                ApellidoM_Emp, Correo_Emp, Direccion_Emp, 
                                Fono_fijo_Emp, Fono_movil_Emp, Tipo_Emp_ID, Activacion 
                            FROM empleado WHERE Rut_Emp = '$this->empleado_rut'";
        db_connect();

        $resultVer = mysql_query($queryEmpleadoVer);

        while ($row = mysql_fetch_array($resultVer)) {
            $empleado[0] = $row["Rut_Emp"];
            $empleado[1] = $row["Nombre_Emp"];
            $empleado[2] = $row["ApellidoP_Emp"];
            $empleado[3] = $row["ApellidoM_Emp"];
            $empleado[4] = $row["Correo_Emp"];
            $empleado[5] = $row["Direccion_Emp"];
            $empleado[6] = $row["Fono_fijo_Emp"];
            $empleado[7] = $row["Fono_movil_Emp"];
            $tipo_emp_id = $row["Tipo_Emp_ID"];

            $queryTipoEmpleado = "SELECT NOMBRE_TIPO_EMP FROM tipo_empleado WHERE TIPO_EMP_ID = $tipo_emp_id;";

            $resultset = mysql_query($queryTipoEmpleado);

            $empleado[8] = mysql_result($resultset, 0);

            $empleado_estado = $row["Activacion"];

            if ($empleado_estado == 0) {
                $empleado[9] = "Desactivado";
            } else {
                $empleado[9] = "Activado";
            }

            $empleado[10] = $tipo_emp_id;
            $empleado[11] = $empleado_estado;
        }
        db_close();
        return $empleado;
    }

    function Emp_Buscar($filtro, $clave, $activacion) {
        if ($filtro == "empleado_rut") {
            $queryEmpleadoBuscar = "SELECT Rut_Emp, Nombre_Emp, ApellidoP_Emp, ApellidoM_Emp, Correo_Emp, Direccion_Emp, Fono_fijo_Emp, Fono_movil_Emp, Tipo_Emp_ID, Activacion 
                                FROM empleado 
                                WHERE Rut_Emp LIKE '%$clave%' AND Activacion = '$activacion'";
        }

        if ($filtro == "empleado_nombre") {
            $queryEmpleadoBuscar = "SELECT Rut_Emp, Nombre_Emp, ApellidoP_Emp, ApellidoM_Emp, Correo_Emp, Direccion_Emp, Fono_fijo_Emp, Fono_movil_Emp, Tipo_Emp_ID, Activacion 
                                FROM empleado 
                                WHERE Nombre_Emp LIKE '%$clave%' AND Activacion = '$activacion'";
        }

        if ($filtro == "empleado_obra_obreros") {
            $queryEmpleadoBuscar = "SELECT empleado.Rut_Emp, empleado.Nombre_Emp
                                FROM empleado, empleado_de_obra
                                WHERE empleado.Rut_Emp = empleado_de_obra.Rut_Emp AND empleado_de_obra.Obra_Id = $clave AND empleado_de_obra.Prioridad = 0 AND empleado_de_obra.Activacion = $activacion";
        }

        if ($filtro == "empleado_obra_supervisor") {
            $queryEmpleadoBuscar = "SELECT empleado.Rut_Emp, empleado.Nombre_Emp, empleado.ApellidoP_Emp, empleado.ApellidoM_Emp, empleado.Correo_Emp, empleado.Direccion_Emp, empleado.Fono_fijo_Emp, empleado.Fono_movil_Emp, empleado.Tipo_Emp_ID, empleado.Activacion 
                                FROM empleado, empleado_de_obra
                                WHERE empleado.Rut_Emp = empleado_de_obra.Rut_Emp AND empleado_de_obra.Obra_Id = $clave AND empleado_de_obra.Prioridad = 1 AND empleado_de_obra.Activacion = $activacion";
        }

        $empleado = array();
        $contador = 0;

        db_connect();
        $resulsetEmpleadoBuscar = mysql_query($queryEmpleadoBuscar);

        while ($row = mysql_fetch_array($resulsetEmpleadoBuscar)) {
            $empleado[$contador][0] = $row["Rut_Emp"];
            $empleado[$contador][1] = $row["Nombre_Emp"];
            $empleado[$contador][2] = $row["ApellidoP_Emp"];
            $empleado[$contador][3] = $row["ApellidoM_Emp"];
            $empleado[$contador][4] = $row["Correo_Emp"];
            $empleado[$contador][5] = $row["Direccion_Emp"];
            $empleado[$contador][6] = $row["Fono_fijo_Emp"];
            $empleado[$contador][7] = $row["Fono_movil_Emp"];
            $empleado[$contador][8] = $row["Tipo_Emp_ID"];
            $empleado[$contador][9] = $row["Activacion"];
            $contador++;
        }

        db_close();
        return $empleado;
    }

    function User_getTiposEmpleados() {
        $tipoEmpleado = array();

        db_connect();

        $queryTipoEmpleado = "SELECT NOMBRE_TIPO_EMP FROM tipo_empleado;";

        $resultset = mysql_query($queryTipoEmpleado);

        if ($resultset == false) {
            $tipoEmpleado = false;
        } else {
            $contador = 0;
            while ($row = mysql_fetch_array($resultset)) {
                $tipoEmpleado[$contador] = $row["NOMBRE_TIPO_EMP"];
                $contador++;
            }
        }
        db_close();
        return $tipoEmpleado;
    }

//    function Emp_NuevoTipoEmpleado($NombreTipo) {
//        db_connect();
//        $query = "INSERT INTO tipo_empleado (Nombre_Tipo_Empleado) VALUES ('$NombreTipo')";
//        if (mysql_query($query)) {
//            $return = true;
//        } else {
//            $return = false;
//        }
//        db_close();
//        return $return;
//    }

}

?>