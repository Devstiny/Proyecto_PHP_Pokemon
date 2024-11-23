<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Team Builder</title>
    <link rel="stylesheet" href="./css/colors.css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex flex-col justify-between">
<?php
    include_once './funciones/funciones_db.php';
    conexion();
    global $pdo;
    session_start();
    $token=$_SESSION['token'];
    if( isset($token)){
        $datosUsu = nombreUsuario($token);
        global $rol;
        $rol = $datosUsu['ROL'];
        global $nombre;
        $nombre = $datosUsu['NOMBRE_USUARIO'];
    }else{
        header("location: ./pages/login.php");
    }
?>

    <!-- Navbar -->
    <header class="bg-primary text-white">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="text-lg font-bold">
                Pokémon Team Builder
            </div>
            <!-- Mobile Menu Button -->
            <button id="menu-button" class="md:hidden text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <!-- Desktop Menu -->
            <nav class="hidden md:flex space-x-6">
                <a href="#" class="hover:text-gray-200">TeamBuild</a>
                <a href="#" class="hover:text-gray-200">Pokemons</a>
                <a href="#" class="hover:text-gray-200">Movimientos</a>
                <a href="#" class="hover:text-gray-200">Perfil</a>
            </nav>
        </div>
        <!-- Mobile Dropdown -->
        <div id="mobile-menu" class="hidden md:hidden bg-primary text-white text-center">
            <a href="#" class="block px-4 py-2 hover:bg-gray-200 hover:text-primary">TeamBuild</a>
            <a href="#" class="block px-4 py-2 hover:bg-gray-200 hover:text-primary">Pokemons</a>
            <a href="#" class="block px-4 py-2 hover:bg-gray-200 hover:text-primary">Movimientos</a>
            <a href="#" class="block px-4 py-2 hover:bg-gray-200 hover:text-primary">Perfil</a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex flex-col justify-center items-center text-center bg-gray-100 xl:w-screen-xl ">
        <h1 class="text-5xl font-bold text-primary mb-6">Crea tu Equipo Pokémon</h1>
        <p class="text-lg text-gray-700 mb-8 max-w-md">
            Personaliza tus equipos con los mejores Pokémon, movimientos y estrategias para la victoria.
        </p>
        <div class="flex space-x-4">
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


</body>
</html>
