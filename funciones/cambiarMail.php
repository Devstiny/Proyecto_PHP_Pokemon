<?php
include_once '.././funciones/funciones_db.php';
session_start();
conexion();
cambiarMail();
header('Location: .././index.php')
?>