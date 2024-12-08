<?php
include_once '.././funciones/funciones_db.php';
session_start();
conexion();
$nom_actual = str_replace('_', ' ', $_POST['nom_act']);
cambiarNombreEquipo($nom_actual, $_POST['nom']);
header('Location: .././pages/equipos.php');
?>