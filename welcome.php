<?php
   include('session.php');
?>
<html">
   
   <head>
      <title>Welcome </title>
   </head>
   
   <body>
      <h1>Bienvenido <?php echo $login_session; ?></h1> 
	  
	  
	  <nav class="dropdownmenu">
  <ul>
    <li><a href="hacerPedido.php">Hacer Pedido</a></li>
    <li><h4>Mis pedidos</h4>
      <ul id="submenu">
        <li><a href="misPedidos.php">Consultar Pedidos</a></li>
        <li><a href="verPorFechas.html">Consultar por fechas</a></li>      </ul>
    </li>
    <li><a href="listadoProductos.php">Listado Productos</a></li>
  
  </ul>
</nav>
	  
	  
	  
      <h2><a href = "logout.php">Cerrar Sesion</a></h2>
   </body>
   
</html>