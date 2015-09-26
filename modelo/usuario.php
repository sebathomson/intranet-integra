<?php

require_once (PATH_ROOT . '/controlador/functions/db_connect.php');

require_once (PATH_ROOT . '/modelo/empleado.php');

class Usuario {

    var $usuario_rut_empleado;
    var $usuario_username;
    var $usuario_password;
    var $usuario_tipo;

    function __construct($v_usuario_username, $v_usuario_password, $v_usuario_tipo, $v_usuario_rut_empleado) {
        $this->usuario_rut_empleado = $v_usuario_rut_empleado;
        $this->usuario_username = $v_usuario_username;
        $this->usuario_password = $v_usuario_password;
        $this->usuario_tipo = $v_usuario_tipo;
    }

    function User_Nuevo() {

        $queryTipo = "SELECT Tipo_Usuario_ID FROM tipo_usuario WHERE NOMBRE_TIPO_USUARIO = '" . $this->usuario_tipo . "'";

        db_connect();

        $resultTipo = db_query_resulset($queryTipo);
        $this->usuario_tipo_id = mysql_result($resultTipo, 0);

        $this->usuario_passwordPunto = str_replace(".", "", $this->usuario_rut_empleado);
        $this->usuario_password = str_replace("-", "", $this->usuario_passwordPunto);

        $queryUser = "INSERT INTO usuario (Rut_Emp, Username, Pass, Tipo_Usuario_ID, Activacion)
                            VALUES ('$this->usuario_rut_empleado', '$this->usuario_username', '$this->usuario_password', $this->usuario_tipo_id, 1 )";

        if (mysql_query($queryUser)) {
            $return = true;
        } else {
            $return = false;
        }

        db_close();

        return $return;
    }

    function User_Modificar_password($usuario_new_password) {

        db_connect();

        $usuario_password_md5 = md5($usuario_new_password);

        $queryModificar = "UPDATE usuario 
                                SET Pass = '$usuario_password_md5'
                                WHERE Username = '$this->usuario_username';";

        if (mysql_query($queryModificar)) {
            $return = true;
        } else {
            $return = false;
        }

        db_close();
        return $return;
    }

    function User_Modificar($usuario_activacion) {

        $queryTipo = "SELECT Tipo_Usuario_ID FROM tipo_usuario WHERE NOMBRE_TIPO_USUARIO = '" . $this->usuario_tipo . "';";

        db_connect();

        $resultTipo = db_query_resulset($queryTipo);
        $this->usuario_tipo_id = mysql_result($resultTipo, 0);

        if ($this->usuario_password == false) {
            $queryModificar = "UPDATE usuario 
                                SET Tipo_Usuario_ID = $this->usuario_tipo_id, Activacion = $usuario_activacion
                                WHERE Username = '$this->usuario_username'";
        } else {

            $usuario_password_md5 = md5($this->usuario_password);

            $queryModificar = "UPDATE usuario 
                                SET Pass = '$usuario_password_md5', Tipo_Usuario_ID = $this->usuario_tipo_id, Activacion = $usuario_activacion
                                WHERE Username = '$this->usuario_username'";
        }

        if (mysql_query($queryModificar)) {
            $return = true;
        } else {
            $return = false;
        }

        db_close();

        return $return;
    }

    function User_Ver() {
        db_connect();

        $usuario = array();

        $queryVer = "SELECT Rut_Emp, Username, Pass, Tipo_Usuario_ID, Activacion FROM usuario
                            WHERE Rut_Emp = '$this->usuario_rut_empleado';";

        $verUsuario = mysql_query($queryVer);

        if ($verUsuario == false) {
            $usuario = false;
        } else {
            while ($row = mysql_fetch_array($verUsuario)) {
                $usuario[0] = $row["Rut_Emp"];
                $usuario[1] = $row["Username"];
                $usuario[2] = $row["Pass"];

                $queryTipo = "SELECT NOMBRE_TIPO_USUARIO FROM tipo_usuario WHERE Tipo_Usuario_ID = '" . $row["Tipo_Usuario_ID"] . "'";
                $resultTipo = db_query_resulset($queryTipo);

                $usuario[3] = mysql_result($resultTipo, 0);

                $usuario_estado = $row["Activacion"];

                if ($usuario_estado == 0) {
                    $usuario[4] = "Desactivado";
                } else {
                    $usuario[4] = "Activado";
                }
            }
        }
        db_close();

        return $usuario;
    }

    function User_getRut() {
        db_connect();

        $query = "SELECT RUT_EMP FROM usuario WHERE USERNAME = '$this->usuario_username';";

        $resultado = db_query_resulset($query);

        $this->usuario_rut_empleado = mysql_result($resultado, 0);

        db_close();

        return $this->usuario_rut_empleado;
    }

    function User_getEmpleadosSinUser() {
        $usuario = array();

        db_connect();

        $query = "SELECT empleado.RUT_EMP FROM empleado LEFT JOIN usuario USING (RUT_EMP) WHERE empleado.ACTIVACION = 1 AND (usuario.ACTIVACION = 0 OR usuario.RUT_EMP IS NULL) ORDER BY empleado.RUT_EMP;";

        $resultset = mysql_query($query);

        if ($resultset == false) {
            $usuario = false;
        } else {
            $contador = 0;
            while ($row = mysql_fetch_array($resultset)) {
                $usuario[$contador] = $row["RUT_EMP"];
                $contador++;
            }
        }
        db_close();

        return $usuario;
    }

    function User_getTiposUsuarios() {
        $usuario = array();

        db_connect();

        $query = "SELECT NOMBRE_TIPO_USUARIO FROM tipo_usuario;";

        $resultset = mysql_query($query);

        if ($resultset == false) {
            $usuario = false;
        } else {
            $contador = 0;
            while ($row = mysql_fetch_array($resultset)) {
                $usuario[$contador] = $row["NOMBRE_TIPO_USUARIO"];
                $contador++;
            }
        }
        db_close();

        return $usuario;
    }

    function User_Buscar($filtro, $clave, $activacion) {
        if ($filtro == "usuario_rut") {
            $queryUsuarioBuscar = "SELECT usuario.Rut_Emp, usuario.Username, usuario.Pass, usuario.Tipo_Usuario_ID, usuario.Activacion 
                                FROM usuario, empleado
                                WHERE empleado.Rut_Emp = usuario.Rut_Emp AND empleado.Rut_Emp LIKE '%$clave%' AND usuario.Activacion = $activacion";
        }

        if ($filtro == "usuario_nombre") {
            $queryUsuarioBuscar = "SELECT Rut_Emp, Username, Pass, Tipo_Usuario_ID, Activacion 
                                FROM usuario
                                WHERE Username LIKE '%$clave%' AND usuario.Activacion = $activacion";
        }
        $usuario = array();
        db_connect();
        $resultsetNom = mysql_query($queryUsuarioBuscar);
        $contador = 0;
        while ($rowNom = mysql_fetch_array($resultsetNom)) {
            $usuario[$contador][0] = $rowNom["Rut_Emp"];
            $usuario[$contador][1] = $rowNom["Username"];
            $usuario[$contador][2] = $rowNom["Pass"];

            $tipo_usuario_id = $rowNom["Tipo_Usuario_ID"];

            $query = "SELECT NOMBRE_TIPO_USUARIO FROM tipo_usuario WHERE tipo_usuario_id = $tipo_usuario_id;";

            $resultset = mysql_query($query);

            $usuario[$contador][3] = mysql_result($resultset, 0);
            $usuario[$contador][4] = $rowNom["Activacion"];
            $contador++;
        }
        db_close();
        return $usuario;
    }

    function User_Validar() {
        db_connect();

        $usuario_password_md5 = md5($this->usuario_password);

        $query = "SELECT USERNAME FROM usuario WHERE USERNAME = '$this->usuario_username' AND PASS = '$usuario_password_md5';";

        $resultset = mysql_query($query);

        if ($resultset == false) {
            db_close();
            return 0;
        } else {
            $validador = mysql_num_rows($resultset);
            db_close();
            return $validador;
        }
    }

}

?>