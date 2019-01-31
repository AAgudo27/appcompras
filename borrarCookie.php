<?php

setcookie('pedidos','', time() -1, "/");
header('Location: /compras/hacerPedido.php');

?>