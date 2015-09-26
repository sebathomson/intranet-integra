<?php

if (defined('PATH_ROOT')) { /* ... */
} else {
    define("PATH_ROOT", $_SERVER['DOCUMENT_ROOT'] . "/");
}

require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');
require_once (PATH_ROOT . '/modelo/lineadeventainsumo.php');
require_once (PATH_ROOT . '/modelo/obra.php');
require_once ('validar.php');

class imprimir {

    var $datos_venta = array();
    var $detalle_venta = array();

    function generar_impresion() {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('IntegraIngenieria');
        $pdf->SetTitle('COMPROBANTE DE EGRESO');
        $pdf->SetSubject('');
        $pdf->SetKeywords('');
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setPrintFooter(false);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // ---------------------------------------------------------
        $pdf->SetFont('helvetica', '', 14);
        $pdf->AddPage();
        $html = '<span style="font-weight: bold;text-decoration: underline; text-align:center;">COMPROBANTE DE EGRESO</span><br>';
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->SetFont('helvetica', '', 11);
        /* Datos de la venta */
        /*
          [0] = Venta ID
          [1] = Rut Cliente
          [2] = Fecha del egreso
          [3] = Rut del Vendedor
         */
        $table_datos = '
        <table>
                <tr>
                        <td>Venta ID: <span style="font-weight: bold;">' . $this->datos_venta[0][0] . '</span></td>
                </tr>
                <tr>
                        <td>Cliente: <span style="font-weight: bold;">' . $this->datos_venta[0][1] . '</span></td>
                </tr>
                <tr>
                        <td>Fecha Egreso: <span style="font-weight: bold;">' . $this->datos_venta[0][2] . '</span></td>
                </tr>
        </table>
        ';
        $pdf->writeHTML($table_datos, true, false, true, false, '');
        /* Detalle de la venta */
        /*
          [x][0]= Nombre Material
          [x][1] = CANTIDAD
         */
        $table_detalle = '
        <table border="1">
        <tr>
                <td><span style="font-weight: bold;">NOMBRE MATERIAL</span></td>
                <td><span style="font-weight: bold;">CANTIDAD</span></td>
        </tr>'
        ;
        for ($count = 0; count($this->detalle_venta) > $count; $count++) {
            $table_detalle .= '
        <tr>
                <td>' . $this->detalle_venta[$count][0] . '</td>
                <td>' . $this->detalle_venta[$count][1] . '</td>
        </tr>
        ';
        }
        $table_detalle .= '</table>';
        $pdf->writeHTML($table_detalle, true, false, true, false, '');
        // ---------------------------------------------------------
        $pdf->Output('example_002.pdf', 'I');
    }

    function buscar_egresos() {
        $tipo_egreso = $_GET["tipo"];
        $busqueda = $_GET["id"];
        if ($tipo_egreso == "insumos") {
            $validar = validarID($busqueda);
            if ($validar) {
                $insumos = array();
                $insumos = $this->LineaDeVenta_Buscar($busqueda);
                $this->datos_venta = $insumos[0];
                $this->detalle_venta = $insumos[1];
            } else {
                $datos = array("", "", "", "");
                $this->datos_venta = $datos;
                $detalle = array();
                $detalle[0][0] = "";
                $detalle[0][1] = "";
                $this->detalle_venta = $detalle;
            }
        } elseif ($tipo_egreso == "obra") {
            $validar = validarID($busqueda);
            if ($validar) {
                $obra_instancia = new Obra($busqueda, 0, 0, 0, 0);
                $obra = array();
                $obra = $obra_instancia->Obra_Ver();
                $datos = array();
                $datos[0][0] = $obra[0];
                $datos[0][1] = $obra[10];
                $datos[0][2] = $obra[4];
                $this->datos_venta = $datos;
                $materiales = $obra[9];
                $material_nuevo = array();
                for ($count = 0; count($materiales) > $count; $count++) {
                    $material_nuevo[$count][0] = $materiales[$count][2];
                    $material_nuevo[$count][1] = $materiales[$count][1];
                }
                $this->detalle_venta = $material_nuevo;
                if ($obra == false) {
                    $datos = array("", "", "", "");
                    $this->datos_venta = $datos;
                    $detalle = array();
                    $detalle[0][0] = "";
                    $detalle[0][1] = "";
                    $this->detalle_venta = $detalle;
                }
            } else {
                $datos = array("", "", "", "");
                $this->datos_venta = $datos;
                $detalle = array();
                $detalle[0][0] = "";
                $detalle[0][1] = "";
                $this->detalle_venta = $detalle;
            }
        } else {
            $datos = array("", "", "", "");
            $this->datos_venta = $datos;
            $detalle = array();
            $detalle[0][0] = "";
            $detalle[0][1] = "";
            $this->detalle_venta = $detalle;
        }
    }

    function LineaDeVenta_Buscar($busqueda) {
        $query = "SELECT * FROM venta_de_material WHERE VENTA_MATERIAL_ID = $busqueda";
        db_connect();
        $resulsetRut = mysql_query($query);
        $contador = 0;
        $egresos = array();
        while ($rowRut = mysql_fetch_array($resulsetRut)) {
            $egresos[$contador][0] = $busqueda;
            $egresos[$contador][1] = $rowRut["RUT_CLI"];
            $egresos[$contador][2] = $rowRut["FECHA"];
            $contador++;
        }
        $egresos_cont = array();
        for ($count = 0; count($egresos) > $count; $count++) {
            $vta_id = $egresos[$count][0];
            $query_egreso = "SELECT * FROM egreso_material_venta WHERE venta_material_id = $vta_id";
            $resulset_egreso = mysql_query($query_egreso);
            $contadors = 0;
            while ($rowRuts = mysql_fetch_array($resulset_egreso)) {
                $egresos_cont[$contadors][2] = $rowRuts["MATERIAL_ID"];
                $egresos_cont[$contadors][1] = $rowRuts["CANTIDAD"];
                $contadors++;
            }
        }
        db_close();
        for ($counts = 0; count($egresos_cont) > $counts; $counts++) {
            $material_id = $egresos_cont[$counts][2];
            $instancia_material = new Material($material_id, 0, 0, 0, 0, 0);
            $material = array();
            $material = $instancia_material->Mat_Ver();
            $egresos_cont[$counts][0] = $material[2];
        }
        $return = array();
        $return[0] = $egresos;
        $return[1] = $egresos_cont;
        return $return;
    }

}

$imprimir = new imprimir();
$imprimir->buscar_egresos();
$imprimir->generar_impresion();










