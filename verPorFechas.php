<?php
 session_start();
require 'config.php';
require 'funciones.php';


$inicio=$_REQUEST['inicio'];
$final=$_REQUEST['final'];

listarProductosPorFecha($db,$inicio,$final);

echo "<a href = 'welcome.php'>VOLVER</a> ";
//SacarOrderPedido($conn);


?>