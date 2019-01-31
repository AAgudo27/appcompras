
<HTML>
<HEAD> <TITLE> Alejandro cabañas</TITLE>
</HEAD>
<BODY>
<form name='mi_formulario' action='hacerPedido1.php' method='post'>


<h3>productos</h3>

<?php
require 'config.php';
require 'funciones.php';

echo "<select name='producto'>";


$sql="select productname from products ;";
$sentencia=mysqli_query($db, $sql);

	
	while($linea=mysqli_fetch_assoc($sentencia)){
		echo "<option value='".$linea['productname']."'>".$linea['productname']."</option>";
	}

	
	
echo "</select>";
	echo "Cantidad <input type='number' name='cantidad' value='' size=20><br>";
?>

<input type="hidden" name="pagina" value="1">



<br><br><br>
<input type="submit" value='añadir a la Cesta'><br>
<a href="vercesta.php">Hacer el pedido</a><br>
<a href="borrarCookie.php">borrar pedido</a><br>

<a href = 'welcome.php'>VOLVER</a>


</FORM>
</BODY>
</HTML>
<?php


if(isset($_COOKIE['pedidos'])){
echo "<table border='1'>";
 echo "<th> Producto</th><th>Cantidad Pedida</th><th>Stock</th>";
 echo '</tr>';
foreach (unserialize($_COOKIE['pedidos']) as $key => $value) {
	$stock=comprobarCantidadStock($db,$key);

		if($value<=$stock){		
		
		echo '<tr>';
		echo "<td style='color:green'>".$key."</td><td  style='color:green'>".$value."</td><td  style='color:green'>".$stock."</td>";
		echo '</tr>';
		}
		else{
		echo '<tr>';
		echo "<td  style='color:red'>".$key."</td><td  style='color:red'>".$value."</td><td  style='color:red'>".$stock."</td>";
		echo '</tr>';
		}
		
	}
	echo "</table>";
//var_dump(unserialize($_COOKIE['pedidos']));
}


?>