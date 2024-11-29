<?php
include_once './../funciones/funciones_db.php';
session_start();
conexion();
cambiarUsu();
header('Location: ./../index.php')
?>