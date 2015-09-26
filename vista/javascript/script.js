/* MODIFICAR */

function modificarOk(){
    $.msgbox("El registro fue modificado exitosamente.", 
    {
        type: "confirm",
        buttons : [
        {
            type: "submit", 
            value: "Aceptar"
        }
        ]
    }); 
}

function modificarError(){
    $.msgbox("El registro no pudo ser modificado. Por favor, inténtelo otra vez.", 
    {
        type: "error",
        buttons : [
        {
            type: "submit", 
            value: "Aceptar"
        }
        ]
    }); 
}

/* MODIFICAR */

/* CREAR */

function crearOk(){
    $.msgbox("El registro fue creado exitosamente.", 
    {
        type: "confirm",
        buttons : [
        {
            type: "submit", 
            value: "Aceptar"
        }
        ]
    }); 
}

function crearError(){
    $.msgbox("El registro no pudo ser creado. Por favor, inténtelo otra vez.", 
    {
        type: "error",
        buttons : [
        {
            type: "submit", 
            value: "Aceptar"
        }
        ]
    }); 
}

/* CREAR */

/* ELIMINAR */

function eliminarOk(){
    $.msgbox("El registro fue eliminado exitosamente.", 
    {
        type: "confirm",
        buttons : [
        {
            type: "submit", 
            value: "Aceptar"
        }
        ]
    }); 
}

function eliminarError(){
    $.msgbox("El registro no pudo ser eliminado. Por favor, inténtelo otra vez.", 
    {
        type: "error",
        buttons : [
        {
            type: "submit", 
            value: "Aceptar"
        }
        ]
    }); 
}

/* ELIMINAR */

function idError(){
    $.msgbox("No existe un registro con ese ID.", 
    {
        type: "error",
        buttons : [
        {
            type: "submit", 
            value: "Aceptar"
        }
        ]
    }); 
}

function busquedaError(){
    $.msgbox("No se encontraron coincidencias.", 
    {
        type: "error",
        buttons : [
        {
            type: "submit", 
            value: "Aceptar"
        }
        ]
    }); 
}

function loginError(){
    $.msgbox("Datos erróneos. Por favor, inténtelo otra vez.", 
    {
        type: "error",
        buttons : [
        {
            type: "submit", 
            value: "Aceptar"
        }
        ]
    }); 
}

function welcome(){
    $.msgbox("¡Bienvenido!", 
    {
        type: "confirm",
        buttons : [
        {
            type: "submit", 
            value: "Aceptar"
        }
        ]
    });     
}

function administracionModulos(){
    var x=document.getElementById("administracionModulos");
    var id_selected = x.selectedIndex;
    
    /* 0 = no-option
     * 1 = Bodega
     * 2 = Obras
     * 3 = Ventas
     * 4 = Stock
     * 5 = Administrar
     */
    if(id_selected == 1){
        location.href="../bodega/materiales.php"; // ARREGLAR
    }else if(id_selected == 2){
        location.href="../obra/servicios.php";
    }else if(id_selected == 3){
        location.href="../venta/servicios.php";
    }else if(id_selected == 4){
        location.href="../stock/stock.php";
    }else if(id_selected == 5){
        location.href="../adm/administracion.php";
    }
    
}

function passwordError(){
    $.msgbox("Su Password no pudo ser cambiada, intentelo nuevamente.", 
    {
        type: "error",
        buttons : [
        {
            type: "submit", 
            value: "Aceptar"
        }
        ]
    }); 
}

function passwordOk(){
    $.msgbox("Su Password ha sido cambiada correctamente.", 
    {
        type: "confirm",
        buttons : [
        {
            type: "submit", 
            value: "Aceptar"
        }
        ]
    });       
}

