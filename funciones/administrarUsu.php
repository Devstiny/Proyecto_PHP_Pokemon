<?php
include_once '.././funciones/funciones_db.php';
session_start();
conexion();
(isset($_POST['rol']))? cambiarRol($_POST['nom'], $_POST['rol']) : eliminarUsu($_POST['del']);
header('Location: .././pages/admin.php');
?>