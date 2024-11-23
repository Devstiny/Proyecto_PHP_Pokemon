<?php
    include_once './funciones/funciones_db.php';
    conexion();
    global $pdo;
      session_start();
      $token=$_SESSION['token'];
    if( isset($token)){
        echo "<h1>HOLAAAAA</h1>";
        $datosUsu = nombreUsuario($token);
        echo "<h2>Bienvenido ". $datosUsu['NOMBRE_USUARIO'] ." con Rol ". $datosUsu['ROL'] ."</h2>";
    }else{
        header("location: ./pages/login.php");
    }
?>
