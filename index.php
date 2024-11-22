<?php
    include_once './funciones/funciones_db.php';
    conexion();
    global $pdo;
      session_start();
      $token=session_id();
    if( isset($_SESSION['token'])){
        echo "<h1>HOLAAAAA</h1>";
    }else{
        header("location: ./pages/login.php");
    }
?>
