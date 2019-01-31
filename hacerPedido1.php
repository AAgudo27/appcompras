<?php
//echo $_POST['producto'];
require 'config.php';
require 'funciones.php';

 
if(isset($_COOKIE['pedidos'])){
	$array=unserialize($_COOKIE['pedidos']);

	$producto=$_POST['producto'];
	$cantidad=$_POST['cantidad'];

		if(empty($cantidad)){
			$cantidad=0;
		}
	
		
				
				foreach (unserialize($_COOKIE['pedidos']) as $key => $value) {
					if($key==$producto){
						$cantidad+=$value;
					}
				}	
			
			
				$array[$producto]= $cantidad;
			


		setcookie('pedidos',serialize($array), time() + (86400 * 30), "/");

	

		//var_dump($_COOKIE);
		header('Location: /compras/hacerPedido.php');

}
else{

	$array = array(
    $_POST['producto'] => $_POST['cantidad']
		);

	setcookie('pedidos',serialize($array), time() + (86400 * 30), "/");

	header('Location: /compras/hacerPedido.php');

}

/*
if(isset($_POST['producto']) && isset($_POST['cantidad'])){

	

	if(isset($array)){
		$other=array( $_POST['producto'] =>$_POST['cantidad'] );

		$array=arrary_merge( $other, $array);
		echo 'good';
	}
	else{
		$array = array(
    $_POST['producto'] => $_POST['cantidad']
		);

		echo 'bad';
	}
	
	//setcookie('pedidos',"", time() -1);

		$cookie_name = "pedidos";
		echo $cookie_name;
		//print_r($array);

		setcookie($cookie_name, serialize($array), time() + (86400 * 30), "/"); // 86400 segundos = 1 día
		//echo $cookie_name;
		var_dump($_COOKIE);
		//header('Location: /compras/hacerPedido.php');

}
else{
	echo "no existe";
}

*/
?>