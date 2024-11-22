<?php
// conexión
function conexion()
{
    global $pdo;
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=pokemon', 'admin', 'admin');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('SET NAMES "utf8"');
    } catch (PDOException $e) {
        echo 'Error en la conexión: ' . $e->getMessage();
    }
}
?>
