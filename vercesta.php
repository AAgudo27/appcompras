<?php
 session_start();
require 'config.php';
require 'funciones.php';


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
else{
	echo "No hay productos en la cesta";
}

$cliente=$_SESSION['id_user'];
$numeropedido=altaPedido($db,$cliente);

if(isset($_COOKIE['pedidos'])){
foreach (unserialize($_COOKIE['pedidos']) as $key => $value) {

		altapedidodetails($db,$cliente,$key,$value,$numeropedido);
}
}

echo "<a href = 'hacerPedido.php'>VOLVER</a> ";



?>