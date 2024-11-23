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

function nombreUsuario($token) {
    global $pdo;
    try {
        $stmt = $pdo -> prepare('SELECT NOMBRE_USUARIO, ROL FROM USUARIOS WHERE TOKEN LIKE :token');
        $stmt -> bindParam(':token', $token);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }catch (PDOException $e) {
        echo 'Error en la conexion: ' . $e->getMessage();
    }
}
?>
