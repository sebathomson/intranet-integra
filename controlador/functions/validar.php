<?php

/*
 * Validar los ID
 * Validar las Fechas
 * Validar los Nombres
 * Validar los Rut
 * Validar las Correos
 * Validar las Descripciones
 * Validar los Fono_Fijo
 * Validar los Fono_Movil
 * Validar las Password
 */

function validarFechas($input, $format="") {
    $separator_type = array(
        "/",
        "-",
        "."
    );
    foreach ($separator_type as $separator) {
        $find = stripos($input, $separator);
        if ($find <> false) {
            $separator_used = $separator;
        }
    }
    $input_array = explode($separator_used, $input);
    if ($format == "mdy") {
        return checkdate($input_array[0], $input_array[1], $input_array[2]);
    } elseif ($format == "ymd") {
        return checkdate($input_array[1], $input_array[2], $input_array[0]);
    } else {
        return checkdate($input_array[1], $input_array[0], $input_array[2]);
    }
    $input_array = array();
}

function validarUsername($valor) {
    $patron_exp = "/^[a-zA-Z\.]{6,15}$/"; // el username puede tener un punto entre medio
    return preg_match($patron_exp, $valor);
}

function validarNombre($valor) {
    $patron_exp = "/^([A-Za-z\s]+)$/"; // el username puede tener un punto entre medio
    return preg_match($patron_exp, $valor);
}

function validarDescripcion($valor) {
    $patron_exp = "/^[[:alnum:][:space:][:punct:]]{0,1000}$/";
    return preg_match($patron_exp, $valor);
}

function validarUbicacion($valor) {
    $patron_exp = "/^[[:alnum:][:space:][:punct:]]{5,50}$/";
    return preg_match($patron_exp, $valor);
}

function validarMaterialNombre($valor) {
    $patron_exp = "/^[[:alnum:][:space:][:punct:]]{5,50}$/";
    return preg_match($patron_exp, $valor);
}

function validarEmail($valor) {
    $patron_exp = "/\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b/";
    return preg_match($patron_exp, $valor);
}

function validarID($valor) {
    $patron_exp = "/^[0-9]{1,4}$/";
    return preg_match($patron_exp, $valor);
}

function validarFonoFijo($valor) {
    $patron_exp = "/^[0-9]{7,10}$/";
    return preg_match($patron_exp, $valor);
}

function validarFonoMovil($valor) {
    $patron_exp = "/^[0-9]{8,9}$/";
    return preg_match($patron_exp, $valor);
}

function validarPassword($valor) {
    $patron_exp = "/^[[:alnum:]]{6,15}$/";
    return preg_match($patron_exp, $valor);
}

function validarRut($valor) {
    $valor = strtoupper($valor);
    $rut01 = str_replace(".", "", $valor);
    $rut = str_replace("-", "", $rut01);
    $sub_rut = substr($rut, 0, strlen($rut) - 1);
    $sub_dv = substr($rut, -1);
    $x = 2;
    $s = 0;
    for ($i = strlen($sub_rut) - 1; $i >= 0; $i--) {
        if ($x > 7) {
            $x = 2;
        }
        $s += $sub_rut[$i] * $x;
        $x++;
    }
    $dv = 11 - ($s % 11);
    if ($dv == 10) {
        $dv = 'K';
    }
    if ($dv == 11) {
        $dv = '0';
    }
    if ($dv == $sub_dv) {
        return true; // Rut Correcto.
    } else {
        return false; // Rut Erroneo.
    }
}

function validarRutGuion($valor){
    $guion = strripos($valor, "-");
    if($guion===FALSE){
        //no existe el guion en el rut
        return false;
    }else{
        return $valor;
    }
}

//echo validarFonoFijo("5555555");
//echo validarFonoMovil("85844725");
//echo validarRut("17.243.834-2");
//echo validarEmail("seba@thomson.cl");
//echo validarUbicacion("Casa #3333");
//echo validarNombre("Sebastian");
?>