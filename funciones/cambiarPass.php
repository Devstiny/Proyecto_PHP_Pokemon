<?php
include_once './../funciones/funciones_db.php';
session_start();
conexion();
cambiarPass();
header('Location: ./../index.php')
?>