<?php 
session_start();
extract($_REQUEST);
//la funci�n extract toma las claves de una matriz asoiativa y las convierte en nombres de variable,
//asign�ndoles a esas variables valores iguales a los que ten�a asociados en la matriz. Es decir, convierte a $_GET['id'] en $id,
//sin que tengamos que tomarnos el trabajo de escribir $id=$_GET['ID']; 
mysql_connect("localhost","thomson_taller","thomson_taller0");
mysql_select_db("thomson_taller");
//inclu�mos la conexi�n a nuestra base de datos
$qry=mysql_query("select Nombre_Mat, Material_ID from material where Material_ID ='".$id."'");
$row=mysql_fetch_array($qry);

$que = "SELECT Stock FROM contiene WHERE Material_ID ='".$id."' AND Bodega_ID = '".$bod."'";

$queryStock = mysql_query($que);
$rowStock=mysql_fetch_array($queryStock);

require_once ("validar.php");

if(!isset($cantidad)){
    $cantidad=1;
    }else{
        if($cantidad > $rowStock['Stock']){
           $cantidad=1;
        }
        if(validarFonoFijo($rowStock['Stock'])){
           $cantidad=1;  
        }
    }
    
    $cod = $id."-".$bod;
    
//Como tambi�n vamos a usar este archivo para actualizar las cantidades,
//hacemos que cuando la misma no est� indicada sea igual a 1
///////////////////
//Si ya hemos introducido alg�n producto en el carro lo tendremos guardado temporalmente
//en el array superglobal $_SESSION['carro'], de manera que rescatamos los valores de dicho array
//y se los asignamos a la variable $carro, previa comprobaci�n con isset de que $_SESSION['carro']
//ya haya sido definida
if(isset($_SESSION['carro']))
$carro=$_SESSION['carro'];
//Ahora introducimos el nuevo producto en la matriz $carro, utilizando como �ndice el id del producto
//en cuesti�n, encriptado con md5. Utilizamos md5 porque genera un valor alfanum�rico que luego,
//cuando busquemos un producto en particular dentro de la matriz, no podr� ser confundido con la posici�n
//que ocupa dentro de dicha matriz, como podr�a ocurrir si fuera s�lo num�rico.
//Cabe aclarar que si el producto ya hab�a sido agregado antes, los nuevos valores que le asignemos reemplazar�n
//a los viejos. 
//Al mismo tiempo, y no porque sea estrictamente necesario sino a modo de ejemplo, guardamos m�s de un valor 
//en la variable $carro, vali�ndonos de nuevo de la herramienta array.
$carro[md5($cod)]=array('identificador'=>md5($cod),
                        'cantidad'=>$cantidad,
                        'bodega'=>$bod,
                        'material'=>$row['Nombre_Mat'],
                        'materialID'=>$row['Material_ID'],
                        'stock'=>$rowStock['Stock'],
                        'id'=>$id);
//Ahora dentro de la sesi�n ($_SESSION['carro']) tenemos s�lo los valores que ten�amos (si es que ten�amos alguno) antes de ingresar
//a esta p�gina y en la variable $carro tenemos esos mismos valores m�s el que acabamos de sumar. De manera que 
//tenemos que actualizar (reemplazar) la variable de sesi�n por la variable $carro.
$_SESSION['carro']=$carro;
//Y volvemos a nuestro cat�logo de art�culos. La cadena SID representa al identificador de la sesi�n, que, dependiendo 
//de la configuraci�n del servidor y de si el usuario tiene o no activadas las cookies puede no ser necesario pasarla por la url.
//Pero para que nuestro carro funcione, independientemente de esos factores, conviene escribirla siempre.
if ($sector == "carro") {
    header("Location: ../../vista/venta/stock_carro.php?".SID);
}else{
header("Location: ../../vista/venta/stock.php?".SID);
}
?>