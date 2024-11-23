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

function inicioSesion()
{
    global $pdo;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['nombre'];
        $pass = $_POST['pass'];
        $consulta = "SELECT * FROM USUARIOS WHERE NOMBRE_USUARIO = :nombre AND PASSWORD = :password";
        $stmt = $pdo->prepare($consulta);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':password', $pass, PDO::PARAM_STR);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($resultado) {
            session_start();
            $token = hash('sha256', uniqid(mt_rand(), true));
            $_SESSION['token'] = $token;
            $inserToken = "UPDATE USUARIOS SET TOKEN = :token WHERE NOMBRE_USUARIO = :nombre";
            $stmt = $pdo->prepare($inserToken);
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->execute();
            header("location: .././index.php");
        } else {
            echo "Credenciales incorrectas.";
        }
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
