<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Team Builder</title>
    <link rel="icon" type="image/x-icon" href=".././assets/images/Pokemon-Pokeball-PNG-Images.webp">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href=".././css/colors.css" />
    <!-- FONTAWESOME -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100 h-screen flex flex-col justify-between">
    <?php
    include_once '.././funciones/funciones_db.php';
    conexion();
    global $pdo;
    session_start();
    $token = $_SESSION['token'];
    if (isset($token)) {
        $datosUsu = nombreUsuario($token);
        global $rol;
        $rol = $datosUsu['ROL'];
        global $nombre;
        $nombre = $datosUsu['NOMBRE_USUARIO'];
        global $mail;
        $mail = $datosUsu['MAIL'];
    } else {
        header("location: ./pages/login.php");
    }
    if ($rol != 'A')
        header("location: ./login.php");

    ?>

    <!-- Navbar -->
    <header class="bg-primary text-white">
        <div class="container mx-auto px-1 py-1 flex justify-between items-center">
        <a href=".././index.php"><img src=".././assets/images/LOGOTIPO.png" class="drop-shadow-lg w-20"></a>
            <!-- Mobile Menu Button -->
            <button id="menu-button" class="md:hidden text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <!-- Desktop Menu -->
            <nav class="hidden md:flex space-x-6">

                <a href=".././pages/teamBuilder.php" class="hover:text-gray-200">TeamBuilder</a>
                <a href=".././pages/pokedex.php" class="hover:text-gray-200">Pokedex</a>
                <a href=".././pages/movimientos.php" class="hover:text-gray-200">Movimientos</a>
                <a href=".././pages/equipos.php" class="hover:text-gray-200">Mis Equipos</a>
                <?php
                if ($rol === "A") { ?>
                    <a href='#' class='hover:text-gray-200'>Administración</a>
                <?php
                } ?>
                <div class="relative">
                    <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="hover:text-gray-200 border-2 rounded-full px-[6px] py-[2px] text-center" type="button"><i class="fa-regular fa-user"></i></button>
                    <div id="dropdown" class="hidden absolute bg-primary text-white border rounded shadow-md mt-5 right-0 z-50 w-48 text-center">
                        <a href=".././pages/cuenta.php" class="block px-8 py-2 hover:bg-red-200 hover:text-black transition-all">Mi Cuenta</a>
                        <a href=".././funciones/cerrarSesion.php" class="block px-8 py-2 hover:bg-red-200 hover:text-black transition-all">Cerrar Sesión</a>
                    </div>
                </div>

            </nav>
        </div>
        <!-- Mobile Dropdown -->
        <div id="mobile-menu" class="hidden md:hidden bg-primary text-white text-center">
            <a href=".././pages/teamBuilder.php" class="block px-4 py-2 hover:bg-gray-200 hover:text-primary">TeamBuilder</a>
            <a href=".././pages/pokedex.php" class="block px-4 py-2 hover:bg-gray-200 hover:text-primary">Pokedex</a>
            <a href=".././pages/movimientos.php" class="block px-4 py-2 hover:bg-gray-200 hover:text-primary">Movimientos</a>
            <a href=".././pages/equipos.php" class="block px-4 py-2 hover:bg-gray-200 hover:text-primary">Mis Equipos</a>
            <?php
            if ($rol === "A") { ?>
                <a href='#' class='hover:text-gray-200'>Administración</a>
            <?php
            } ?>
            <a href=".././pages/cuenta.php" class="block px-4 py-2 hover:bg-gray-200 hover:text-primary">Mi Cuenta</a>
            <a href=".././funciones/cerrarSesion.php" class="block px-4 py-2 hover:bg-gray-200 hover:text-primary">Cerrar Sesión</a>

        </div>
    </header>

    <!-- Main Content -->
    <main class="flex flex-col justify-center items-center text-center bg-gray-100 xl:w-screen-xl ">
        <h1 class="text-5xl font-bold text-primary mb-6">Administrar cuentas</h1>
        <table>
            <thead> 
                <tr>
                    <th class="border border-gray-200 p-4">Nombre</th>
                    <th class="border border-gray-200 p-4">Mail</th>
                    <th class="border border-gray-200 p-4">Rol</th>
                    <th class="border border-gray-200 p-4">Equipos</th>
                    <th class="p-4"></th>
                    <th class="p-4"></th>
                </tr>
            </thead>
            <tbody>
                    <?php
                        tablaUsuarios();
                    ?>  
            </tbody>
        </table>
    </main>

    <!-- Footer -->
    <footer class="bg-primary text-white py-4 text-center">
        Pokémon Team Builder © 2024. Todos los derechos reservados.
    </footer>

    <script>
        // Mobile menu toggle
        const menuButton = document.getElementById('menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        menuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

</body>

</html>