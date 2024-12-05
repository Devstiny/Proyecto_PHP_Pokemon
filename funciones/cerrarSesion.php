<?php
// Inicia la sesión en PHP, permitiendo el acceso a las variables de sesión
session_start();

// Elimina todas las variables de sesión almacenadas
session_unset();

// Destruye la sesión actual, eliminando los datos de sesión
session_destroy();

// Redirige al usuario a la página de inicio
header('location: ./../index.php');
