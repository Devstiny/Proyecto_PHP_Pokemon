<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Team Builder</title>
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
    ?>

    <!-- Navbar -->
    <header class="bg-primary text-white">
        <div class="container mx-auto px-1 py-1 flex justify-between items-center">
            <img src=".././assets/images/LOGOTIPO.png" alt="" class="drop-shadow-lg w-20">
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
                    <a href='.././pages/admin.php' class='hover:text-gray-200'>Administración</a>
                <?php
                } ?>
                <div class="relative">
                    <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="hover:text-gray-200 border-2 rounded-full px-[6px] py-[2px] text-center" type="button"><i class="fa-regular fa-user"></i></button>
                    <div id="dropdown" class="hidden absolute bg-primary text-white border rounded shadow-md mt-5 right-0 z-50 w-48 text-center">
                        <a href="#" class="block px-8 py-2 hover:bg-red-200 hover:text-black transition-all">Mi Cuenta</a>
                        <a href="./../funciones/cerrarSesion.php" class="block px-8 py-2 hover:bg-red-200 hover:text-black transition-all">Cerrar Sesión</a>
                    </div>
                </div>

            </nav>
        </div>
        <!-- Mobile Dropdown -->
        <div id="mobile-menu" class="hidden md:hidden bg-primary text-white text-center">
            <a href="#" class="block px-4 py-2 hover:bg-gray-200 hover:text-primary">TeamBuilder</a>
            <a href="#" class="block px-4 py-2 hover:bg-gray-200 hover:text-primary">Pokedex</a>
            <a href="#" class="block px-4 py-2 hover:bg-gray-200 hover:text-primary">Mis Equipos</a>
            <?php
            if ($rol === "A") { ?>
                <a href='#' class='hover:text-gray-200'>Administración</a>
            <?php
            } ?>
            <a href="#" class="block px-4 py-2 hover:bg-gray-200 hover:text-primary">Mi Cuenta</a>
            <a href="./../funciones/cerrarSesion.php" class="block px-4 py-2 hover:bg-gray-200 hover:text-primary">Cerrar Sesión</a>

        </div>
    </header>

    <!-- Main Content -->
    <main class="flex flex-col justify-center items-center text-center bg-gray-100 xl:w-screen-xl ">
        <h1 class="text-5xl font-bold text-primary mb-6">Mi Cuenta</h1>
        <p class="text-lg text-gray-700 mb-8 max-w-md"> Foto de perfil
            <img class="w-20 mt-6 mx-auto border-2 border-gray-600 rounded-full" src=".././assets/images/pokeball_mew.webp" alt="foto perfil">
        </p>
        <p class="text-lg text-gray-700 max-w-md">
            Nombre de usuario: <?php echo $nombre; ?>
        </p>
        <div id="accordion-collapse" data-accordion="collapse">
            <h2 id="accordion-collapse-heading-1" class="mt-2">
                <button
                    type="button"
                    class="w-full text-white bg-primary hover:bg-red-500 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center justify-center focus:bg-[#D33F5A] focus:hover:bg-red-500 focus:text-white hover:text-white"
                    data-accordion-target="#accordion-collapse-body-1"
                    aria-expanded="false"
                    aria-controls="accordion-collapse-body-1">
                    Editar<i class="fa-regular fa-pen-to-square ml-4"></i>
                </button>
            </h2>
            <!-- Dropdown menu -->
            <div id="accordion-collapse-body-1"
                class="hidden bg-[#D33F5A] rounded-lg shadow w-full p-4 mt-2"
                aria-labelledby="accordion-collapse-heading-1">
                <form action="./../funciones/cambiarUsu.php" method="post">
                    <label for="usu" class="block text-sm text-white mb-2">Nuevo nombre</label>
                    <input type="text" name="usu" id="usu"
                        placeholder="Nuevo nombre"
                        class="w-full px-3 py-2 text-sm text-black border border-[#D33F5A] rounded-md focus:outline-none focus:ring-2 focus:ring-white focus:border-white">
                    <button type="submit"
                        class="mt-2 w-full bg-white text-[#D33F5A] hover:bg-gray-200 px-4 py-2 rounded-md font-medium">
                        Confirmar
                    </button>
                </form>
            </div>


            <p class="text-lg text-gray-700 mt-8 max-w-md">
                Correo electronico: <?php echo $mail; ?>
                <!-- <input type="text" name="usuario" placeholder=""> -->
            </p>


            <h2 id="accordion-collapse-heading-2" class="mt-2">
                <button
                    type="button"
                    class="w-full text-white bg-primary hover:bg-red-500 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center justify-center focus:bg-[#D33F5A] focus:hover:bg-red-500 focus:text-white"
                    data-accordion-target="#accordion-collapse-body-2"
                    aria-expanded="false"
                    aria-controls="accordion-collapse-body-2">
                    Editar<i class="fa-regular fa-pen-to-square ml-4"></i>
                </button>
            </h2>
            <!-- Dropdown menu -->
            <div id="accordion-collapse-body-2"
                class="hidden bg-[#D33F5A] rounded-lg shadow w-full p-4 mt-2"
                aria-labelledby="accordion-collapse-heading-2">
                <form action="./../funciones/cambiarMail.php" method="post">
                    <label for="mail" class="block text-sm text-white mb-2">Nuevo mail</label>
                    <input
                        type="text"
                        name="mail"
                        id="mail"
                        placeholder="Nuevo mail"
                        class="w-full px-3 py-2 text-sm text-black border border-[#D33F5A] rounded-md focus:outline-none focus:ring-2 focus:ring-white focus:border-white">
                    <button type="submit"
                        class="mt-2 w-full bg-white text-[#D33F5A] hover:bg-gray-200 px-4 py-2 rounded-md font-medium">
                        Confirmar
                    </button>
                </form>
            </div>

            <p class="text-lg text-gray-700 mt-8 max-w-md">
                Contraseña: ●●●●●●●●●
                <!-- <input type="text" name="usuario" placeholder=""> -->
            </p>

            <h2 id="accordion-collapse-heading-3" class="mt-2">
                <button
                    type="button"
                    class="w-full text-white bg-primary hover:bg-red-500 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center justify-center focus:bg-[#D33F5A] focus:hover:bg-red-500 focus:text-white"
                    data-accordion-target="#accordion-collapse-body-3"
                    aria-expanded="false"
                    aria-controls="accordion-collapse-body-3">
                    Editar<i class="fa-regular fa-pen-to-square ml-4"></i>
                </button>
            </h2>
            <!-- Dropdown menu -->
            <div id="accordion-collapse-body-3"
                class="hidden bg-[#D33F5A] rounded-lg shadow w-full p-4 mt-2"
                aria-labelledby="accordion-collapse-heading-3">
                <form action="./../funciones/cambiarPass.php" method="post">
                    <label for="pass" class="block text-sm text-white mb-2">Nueva contraseña</label>
                    <input
                        type="text"
                        name="pass"
                        id="pass"
                        placeholder="Nueva contraseña"
                        class="w-full px-3 py-2 text-sm text-black border border-[#D33F5A] rounded-md focus:outline-none focus:ring-2 focus:ring-white focus:border-white">
                    <button type="submit"
                        class="mt-2 w-full bg-white text-[#D33F5A] hover:bg-gray-200 px-4 py-2 rounded-md font-medium">
                        Confirmar
                    </button>
                </form>
            </div>
        </div>

        <div class="flex space-x-4  mt-10">
            <a href="#" class="bg-primary text-white px-6 py-3 rounded-lg shadow-md hover:bg-red-500">
                Crear Equipo
            </a>
            <a href="#" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg shadow-md hover:bg-gray-400">
                Ver Equipos Guardados
            </a>
        </div>
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