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
    $errorMessage = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['nombre'];
        $pass = $_POST['pass'];
        try {
            // Primero buscamos el hash de la contraseña del usuario en la base de datos
            $consulta = "SELECT PASSWORD FROM USUARIOS WHERE NOMBRE_USUARIO = :nombre";
            $stmt = $pdo->prepare($consulta);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado && password_verify($pass, $resultado['PASSWORD'])) {
                // Si la contraseña es correcta, generamos el token y redirigimos
                session_start();
                $token = hash('sha256', uniqid(mt_rand(), true));
                $_SESSION['token'] = $token;

                // Guardamos el token en la base de datos
                $inserToken = "UPDATE USUARIOS SET TOKEN = :token WHERE NOMBRE_USUARIO = :nombre";
                $stmt = $pdo->prepare($inserToken);
                $stmt->bindParam(':token', $token, PDO::PARAM_STR);
                $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                $stmt->execute();

                header("location: .././index.php");
                exit();
            } else {
                // Si no coincide, mostramos un mensaje de error
                $errorMessage =  "El usuario o la contraseña son incorrectos. Inténtelo de nuevo";
            }
        } catch (PDOException $e) {
            echo 'Error en la conexión: ' . $e->getMessage();
        }
    }
    return $errorMessage; // Si no hay errores, será una cadena vacía
}

function nombreUsuario($token)
{
    global $pdo;
    try {
        $stmt = $pdo->prepare('SELECT NOMBRE_USUARIO, ROL, MAIL FROM USUARIOS WHERE TOKEN LIKE :token');
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    } catch (PDOException $e) {
        echo 'Error en la conexion: ' . $e->getMessage();
    }
}

function registrarUsuario($nombreUsuario, $correo, $password)
{
    global $pdo;
    $errorMessage = '';

    try {
        // Verificar si el usuario o el correo ya existen en la BBDD
        $userCheck = "SELECT COUNT(*) FROM USUARIOS WHERE NOMBRE_USUARIO = :nombre_usuario OR MAIL = :mail";
        $stmtCheck = $pdo->prepare($userCheck);
        $stmtCheck->bindParam(':nombre_usuario', $nombreUsuario, PDO::PARAM_STR);
        $stmtCheck->bindParam(':mail', $correo, PDO::PARAM_STR);
        $stmtCheck->execute();
        $userExists = $stmtCheck->fetchColumn();

        if ($userExists > 0) {
            // Si el usuario o el correo ya existen
            $errorMessage = "El nombre de usuario o el correo ya están registrados. Inténtalo de nuevo.";
        } else {
            // Si no, inserta el nuevo usuario
            $insertUser = "INSERT INTO USUARIOS VALUES (:nombre_usuario, :password, 'R', :mail, NULL)";
            $stmtInsert = $pdo->prepare($insertUser);

            // Cifrar la contraseña antes de guardarla
            $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmtInsert->bindParam(':nombre_usuario', $nombreUsuario, PDO::PARAM_STR);
            $stmtInsert->bindParam(':password', $encryptedPassword, PDO::PARAM_STR);
            $stmtInsert->bindParam(':mail', $correo, PDO::PARAM_STR);

            if (!$stmtInsert->execute()) {
                $errorMessage = "Error al insertar los datos en la base de datos.";
            }
        }
    } catch (PDOException $excepcion) {
        $errorMessage = "Error en la inserción: " . $excepcion->getMessage();
    }

    return $errorMessage; // Si no hay errores, será una cadena vacía
}



function cambiarUsu(){
    global $pdo;
    $consulta = "UPDATE USUARIOS SET NOMBRE_USUARIO = :nombre WHERE TOKEN = :token";
    $stmt = $pdo->prepare($consulta);
    $stmt->bindParam(':token', $_SESSION['token'], PDO::PARAM_STR);
    $stmt->bindParam(':nombre', $_POST['usu'], PDO::PARAM_STR);
    $stmt->execute();
}

function cambiarMail(){
    global $pdo;
    $consulta = "UPDATE USUARIOS SET MAIL = :mail WHERE TOKEN = :token";
    $stmt = $pdo->prepare($consulta);
    $stmt->bindParam(':token', $_SESSION['token'], PDO::PARAM_STR);
    $stmt->bindParam(':mail', $_POST['mail'], PDO::PARAM_STR);
    $stmt->execute();
}


function cambiarPass(){
    global $pdo;
    $pass = $_POST['pass'];
    $encryptedPassword = password_hash($pass, PASSWORD_DEFAULT);
    $consulta = "UPDATE USUARIOS SET PASSWORD = :pass WHERE TOKEN = :token";
    $stmt = $pdo->prepare($consulta);
    $stmt->bindParam(':token', $_SESSION['token'], PDO::PARAM_STR);
    $stmt->bindParam(':pass', $encryptedPassword, PDO::PARAM_STR);
    $stmt->execute();
}