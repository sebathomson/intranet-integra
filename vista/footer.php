<?php
if ($_SESSION["session_privilegio"] == "ADMINISTRADOR") {
    ?>
    <div class="clear"></div>
    <!-- INICIO CONTENEDOR -->
    <div id="contenedor_cambio">
        <img class="left" alt="" src="../images/contenedor_corner_left_top.png"/>
        <div name="titulo">
            <span id="titleseccion">CAMBIAR M&Oacute;DULO</span>
            <img class="left" alt="" src="../images/title_right.png" style="margin-right: 100px;"/>
        </div>
        <a href="./../adm/administracion.php" id="enlace_cambio">ADMINISTRACI&Oacute;N</a> |
        <a href="./../bodega/materiales.php" id="enlace_cambio">BODEGA</a> |
        <a href="./../obra/obras.php" id="enlace_cambio">OBRAS</a> |
        <a href="./../venta/servicios.php" id="enlace_cambio">VENTAS</a> |
        <a href="./../stock/stock.php" id="enlace_cambio">STOCK</a>
        <img class="right" alt="" src="../images/contenedor_corner_right_top.png"/>
    </div>
    <script type="text/javascript">
                                    
        $(".editprofile").click(function() {
                                    
            $.msgbox("<p>Cambiar Password:</p>", {
                type    : "prompt",
                inputs  : [
                    {type: "password", label: "Ingrese Password Antigua:", required: true},
                    {type: "password", label: "Ingrese Password Nueva:", required: true},
                    {type: "password", label: "Repita Password Nueva:", required: true}
                ],
                buttons : [
                    {type: "submit", value: "Cambiar"},
                    {type: "cancel", value: "Salir"}
                ]
            }, function(password_old, password_new, password_rep) {
                if (password_old) {
                    document.write("<form method='POST' name='editarpassword' action='../../controlador/controlador_principal.php?accion=editar_password'>");
                    document.write("<input type='hidden' name='password_old' value='"+password_old+"' />");
                    document.write("<input type='hidden' name='password_new' value='"+password_new+"' />");
                    document.write("<input type='hidden' name='password_rep' value='"+password_rep+"' />");
                    document.write("<input type='hidden' name='url' value='"+document.location.href+"' />");
                    document.write("</form>");
                    document.editarpassword.submit();
                }
            });                          
        });
                                    
    </script>
    <?php
}
if (isset($_SESSION["session_editar_password"])) {
    switch ($_SESSION["session_editar_password"]) {
        case "passwordOk":
            $_SESSION["session_editar_password"] = false;
            echo "<SCRIPT type='text/javascript'>window.onload=passwordOk;</SCRIPT>";
            break;
        case "passwordError":
            $_SESSION["session_editar_password"] = false;
            echo "<SCRIPT type='text/javascript'>window.onload=passwordError;</SCRIPT>";
            break;
    }
}

if (isset($_GET["mensaje"])) {
    $mensaje = $_GET["mensaje"];

    switch ($mensaje) {
        case "crearOk":
            echo "<SCRIPT type='text/javascript'>window.onload=crearOk;</SCRIPT>";
            break;
        case "crearError":
            echo "<SCRIPT type='text/javascript'>window.onload=crearError;</SCRIPT>";
            break;
        case "modificarOk":
            echo "<SCRIPT type='text/javascript'>window.onload=modificarOk;</SCRIPT>";
            break;
        case "modificarError":
            echo "<SCRIPT type='text/javascript'>window.onload=modificarError;</SCRIPT>";
            break;
        case "eliminarOk":
            echo "<SCRIPT type='text/javascript'>window.onload=eliminarOk;</SCRIPT>";
            break;
        case "eliminarError":
            echo "<SCRIPT type='text/javascript'>window.onload=eliminarError;</SCRIPT>";
            break;
        case "idError":
            echo "<SCRIPT type='text/javascript'>window.onload=idError;</SCRIPT>";
            break;
        case "busquedaError":
            echo "<SCRIPT type='text/javascript'>window.onload=busquedaError;</SCRIPT>";
            break;
        case "welcome":
            echo "<SCRIPT type='text/javascript'>window.onload=welcome;</SCRIPT>";
            break;
        case "loginError":
            echo "<SCRIPT type='text/javascript'>window.onload=loginError;</SCRIPT>";
            break;
    }
}
?>