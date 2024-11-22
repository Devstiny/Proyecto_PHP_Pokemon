<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>login</title>
    <link rel="icon" type="image/x-icon" href=".././assets/images/Pokemon-Pokeball-PNG-Images.webp">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous"
    />
    <!-- CSS LINK -->
    <link rel="stylesheet" href=".././css/style.css" />
    <!-- FONT LINK -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet" />
    <!-- FONTAWESOME -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>



<!-- Main container -->
<main class="w-screen overflow-hidden m-auto">
    <!-- Section: Design Block -->
    <?php
        include_once '.././funciones/funciones_db.php';
        conexion();
    global $pdo;
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $nombre = $_POST['nombre'];
        $pass = $_POST['pass'];
        $consulta = "SELECT * FROM USUARIOS WHERE NOMBRE_USUARIO = :nombre AND PASSWORD = :password";
        $stmt = $pdo->prepare($consulta);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':password', $pass, PDO::PARAM_STR);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($resultado) {
            //configuracion para que cuando se cierre el navegador se cierre la sesion
            //(Elimina las cookies, por lo tanto elimina el token, que es lo que comprueba el index si existe).
            session_set_cookie_params([
                'lifetime' => 0,
                'path' => '/',
                'secure' => false,
                'httponly' => true,
            ]);
            session_start();
            $token = hash('sha256', uniqid(mt_rand(), true));
            $_SESSION['token'] = $token;
            echo "hola";
            header("location: .././index.php");
        } else {
            echo "Credenciales incorrectas.";
        }
    }
    ?>
    <section class=" min-h-screen flex items-center justify-center">
        <!-- Jumbotron -->
        <div class="flex flex-wrap max-w-[1200px] items-center justify-around gap-5">
            <!-- Form Section -->
            <div class="w-[550px]">
                <div class="bg-white shadow-lg rounded-lg p-8">
                    <h2 class="text-2xl font-bold mb-6">Iniciar Sesion</h2>
                    <form action="#" method="post">
                        <!-- Nombre de usuario -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2" for="nombre">Nombre de usuario</label>
                            <input type="text" id="nombre" name="nombre" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500" required />
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2" for="contrasena">Contraseña</label>
                            <input type="password" id="contrasena" name="pass" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500" required />
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="w-full bg-red-500 text-white py-2 rounded hover:bg-red-600 transition">
                            Iniciar Sesion
                        </button>

                        <!-- Login with social media -->
                        <div class="text-center mt-6">
                            <p class="text-sm mb-4">O inicie sesión con</p>
                            <div class="flex justify-center space-x-4">
                                <button type="button" class="text-red-500 hover:text-red-600">
                                    <i class="fab fa-facebook-f text-xl"></i>
                                </button>
                                <button type="button" class="text-red-500 hover:text-red-600">
                                    <i class="fab fa-google text-xl"></i>
                                </button>
                                <button type="button" class="text-red-500 hover:text-red-600">
                                    <i class="fab fa-twitter text-xl"></i>
                                </button>
                                <button type="button" class="text-red-500 hover:text-red-600">
                                    <i class="fab fa-github text-xl"></i>
                                </button>
                            </div>
                        </div>
                        <div class="text-center mt-6">
                            <p>¿Todavia no estas registrado?</p>
                            <a href="./register.php" class="hover:text-red-500">Registrarse ahora</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Image Section -->
            <div class="relative max-w-[550px]">
                <img src="./../assets/images/pokeball_mew.webp" alt="Imagen" class="mew animaMew capturaMew m-auto" id="mew"/>
                <img src=".././assets/images/Pokemon-Pokeball-PNG-Images.webp" class="pokeball captura" id="pokeball">
            </div>
        </div>
    </section>
</main>


</body>
</html>
