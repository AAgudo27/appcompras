<?php



function verPedidos($db){

	//var_dump($_SESSION);
	$cliente=$_SESSION['id_user'];

	$sql2="Select orders.orderNumber,orders.orderDate,orders.status , orderdetails.orderLineNumber , products.productName , orderdetails.quantityOrdered from orders,customers,orderdetails,products where customers.customernumber=$cliente and customers.customernumber=orders.customernumber and orders.orderNumber=orderdetails.orderNumber and orderdetails.productCode=products.productCode order by orders.orderNumber, orderdetails.orderLineNumber;";


	$resultado2=mysqli_query($db, $sql2);
	$contador=mysqli_num_rows($resultado2);
	echo "Ciente ".$cliente." --".$_SESSION['login_user']."<br>";
	echo $contador. ' Resultados <br>';
		echo "<table border='1'>";
		 echo "<th> orderNumber</th><th>orderDate</th><th>status</th><th>orderLineNumber</th><th>productName</th><th>quantityOrdered</th>";
	        echo '</tr>';
		if (mysqli_num_rows($resultado2) > 0) {
	    while($row = mysqli_fetch_assoc($resultado2)) {
	    	echo '<tr>';
	        echo "<td>". $row["orderNumber"]."</td><td>".$row["orderDate"]."</td><td>".$row['status']."</td><td>".$row['orderLineNumber']."</td><td>".$row['productName']."</td><td>".$row['quantityOrdered']."</td>";
	        echo '</tr>';
	    }
	    echo '</table>';
	    echo '<br><br><br>';
	} else {
	    echo "0 results";
	}
}

function listarProductos($db){

	$sql="Select ProductCode,productName,productLine,productScale,productVendor,productDescription,quantityInStock,buyPrice,MSRP from products";

	$resultado=mysqli_query($db, $sql);
	$contador=mysqli_num_rows($resultado);



	//echo "Ciente ".$cliente." --".$_SESSION['login_user']."<br>";
	echo $contador. ' Resultados <br>';
		echo "<table border='1'>";
		 echo "<th> Codigo Producto </th><th>Nombre Producto</th><th>Linea Producto</th><th>Escala Producto</th><th>Vendedor</th><th>Descripcion</th><th>Cantidad en Stock</th><th>Precio Compra</th><th>MSRP</th>";
	        echo '</tr>';
		if (mysqli_num_rows($resultado) > 0) {
	    while($row = mysqli_fetch_assoc($resultado)) {
	    	echo '<tr>';
	        echo "<td>". $row["ProductCode"]."</td><td>".$row["productName"]."</td><td>".$row['productLine']."</td><td>".$row['productScale']."</td><td>".$row['productVendor']."</td><td>".$row['productDescription']."</td><td>".$row['quantityInStock']."</td><td>".$row['buyPrice']."</td><td>".$row['MSRP']."</td>";
	        echo '</tr>';
	    }
	    echo '</table>';
	    echo '<br><br><br>';
	} else {
	    echo "0 results";
	}

}
function listarProductosPorFecha($db,$inicio,$final){

	$cliente=$_SESSION['id_user'];

	$sql2="Select orders.orderNumber,orders.orderDate,orders.status , orderdetails.orderLineNumber , products.productName , orderdetails.quantityOrdered from orders,customers,orderdetails,products where customers.customernumber=$cliente and customers.customernumber=orders.customernumber and orders.orderNumber=orderdetails.orderNumber and orderdetails.productCode=products.productCode and orderdate between '$inicio' and '$final' order by orders.orderNumber, orderdetails.orderLineNumber;";


	$resultado2=mysqli_query($db, $sql2);
	$contador=mysqli_num_rows($resultado2);
	echo "Ciente ".$cliente." --".$_SESSION['login_user']."<br>";
	echo $contador. ' Resultados <br>';
		echo "<table border='1'>";
		 echo "<th> orderNumber</th><th>orderDate</th><th>status</th><th>orderLineNumber</th><th>productName</th><th>quantityOrdered</th>";
	        echo '</tr>';
		if (mysqli_num_rows($resultado2) > 0) {
	    while($row = mysqli_fetch_assoc($resultado2)) {
	    	echo '<tr>';
	        echo "<td>". $row["orderNumber"]."</td><td>".$row["orderDate"]."</td><td>".$row['status']."</td><td>".$row['orderLineNumber']."</td><td>".$row['productName']."</td><td>".$row['quantityOrdered']."</td>";
	        echo '</tr>';
	    }
	    echo '</table>';
	    echo '<br><br><br>';
	} else {
	    echo "0 results";
	}


}
function comprobarCantidadStock($db,$producto){
	$sql="Select quantityInStock from products where productName='$producto'";

	$aux=mysqli_query($db,$sql);
	$array=mysqli_fetch_array($aux);
	$stock=$array[0];

	return $stock;
}

function altaPedido($conn,$cliente){
	$numeroPedido=maximoOrderNumber($conn);
	$status=SacarOrderPedido($conn);

	//echo $status;

	$sql2= "insert into orders(orderNumber,orderDate,requiredDate,status,customerNumber) values($numeroPedido,CURDATE(),CURDATE(),'$status',$cliente);";

	if($sentencia=mysqli_query($conn,$sql2)){

		return $numeroPedido;
	}
	else{
		//echo "mal3";
		mysqli_rollback($conn);
	}

}
function altapedidodetails($conn,$cliente,$producto,$cant,$numeroPedido){


	$sql="Select quantityInStock from products where productname='$producto';";

	$query=mysqli_query($conn,$sql);
	$arrayselect=mysqli_fetch_array($query);
	$cantidad=$arrayselect[0];

	//echo $cantidad."<br>";
	//echo $producto."<br>";

	if($cant <= $cantidad){
		//echo "se puede realizar la compra del producto ".$producto."<br>";
		$stockFinal=$cantidad-$cant;

		if(!empty($cant)){
			//echo "bien <br>";
			$codigoProducto=codigoProducto($conn,$producto);
			$precioproducto=precioProducto($conn,$codigoProducto);
			$orderline=orderLineNumber($conn,$numeroPedido);
			//echo $numeroPedido."<br>";
			//echo $codigoProducto."<br>";
			//echo $precioproducto."<br>";
			//echo $cont."<br>";

			$sql3="insert into orderdetails(orderNumber,productCode,quantityOrdered,priceEach,orderLineNumber) values ($numeroPedido,'$codigoProducto',$cant,$precioproducto,$orderline);";
					//var_dump($sql3);
					//die();	
				if($sentencia2=mysqli_query($conn,$sql3)){
						//echo "bien <br>";
					$sql4="update products set quantityInStock=$stockFinal where productCode='$codigoProducto'; ";
						if($sentencia3=mysqli_query($conn,$sql4)){
								//echo "bien <br>";
							mysqli_commit($conn);
							$precioTotal=precioTotal($precioproducto,$cant);
							echo '<h5 style="color=black ;padding:5px;background-color:green">Pedido Realizado con Exito. Producto pedido ['.$producto.']. Cantidad Pedida ['.$cant.']. Precio Por unidad ['.$precioproducto.']. Precio Total ['.$precioTotal.'] Numero de Pedido ['.$numeroPedido.'] </h5><br> ';
							
						}
						else{
						//	echo "mal1";
						mysqli_rollback($conn);
					}
				}
				else{
					//echo "mal2";
					mysqli_rollback($conn);
				}
		}
		else{
	echo "<h5 style='color:black;padding:5px; background-color:red'>Compra no realizada Cantidad pedida 0.</h5><br>";
}
	
}
}

function maximoOrderNumber($conn){
	$id2="select MAX(ordernumber) from orders";
	$aux=mysqli_query($conn,$id2);
	$arrayid=mysqli_fetch_array($aux);
	$idok=($arrayid[0])+1;

	//echo $idok." numero pedido<br>";
	return $idok;
}

function SacarOrderPedido($conn){
	$array= array("Shipped","Resolved","In Process");

	$n=rand(0,2);
	
	return $array[$n];
}
function codigoProducto($conn,$nombreProducto){
 
 	$sql="select productCode from products where productName='$nombreProducto';";
 	$aux=mysqli_query($conn,$sql);
	$arrayid=mysqli_fetch_array($aux);
	$codigo=$arrayid[0];

	//echo $codigo;
	return $codigo;
}
function precioProducto($conn,$codigoProduto){
	$sql="select buyPrice from products where productCode='$codigoProduto';";

	$aux=mysqli_query($conn,$sql);
	$arrayid=mysqli_fetch_array($aux);
	$precio=$arrayid[0];

	//echo $precio;
	return $precio;

}
function precioTotal($precio,$cantidad){
	return $precio*$cantidad;
}

function orderLineNumber($conn,$pedido){
	$sql="select ifnull(max(orderlinenumber),0)+1 from orderdetails where orderNumber=$pedido;";
	$aux=mysqli_query($conn,$sql);
	$arrayid=mysqli_fetch_array($aux);
	$orderlinenumber=$arrayid[0];

	return $orderlinenumber;
}

?>