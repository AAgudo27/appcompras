<?php
 session_start();
require 'config.php';
require 'funciones.php';

listarProductos($db);

echo "<a href = 'welcome.php'>VOLVER</a> ";
//SacarOrderPedido($conn);


?>