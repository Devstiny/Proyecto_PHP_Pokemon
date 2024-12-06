<?php
include_once '.././funciones/funciones_db.php';
session_start();
conexion();
cambiarNombreEquipo($_POST['nom_act'], $_POST['nom']);
header('Location: .././pages/equipos.php');
?>