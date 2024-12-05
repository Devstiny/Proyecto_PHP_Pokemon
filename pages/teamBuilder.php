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

    <style>
        .hidden {
            display: none;
        }
    </style>

    <?php
    // Incluir funciones de conexión y manejo de base de datos
    include_once '.././funciones/funciones_db.php';
    conexion();
    global $pdo;
    session_start();
    $token = $_SESSION['token'];
    //Verificar si el usuario está autenticado a través de la sesión
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


    // Obtener Pokémon y movimientos desde la base de datos
    $pokemons = getPokedex();
    $movimientos = getMovimientos();

    //Verificar y procesar el formulario al recibir datos mediante POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Procesar datos del formulario
        $nombreEquipo = $_POST['nombre_equipo'];
        $pokemonSeleccionados = $_POST['pokemon'];  // Aquí asignamos $_POST['pokemon'] a la variable

        // Verificar que se seleccionaron los 6 Pokémon
        if (count(array_filter($pokemonSeleccionados)) !== 6) {
            die("Debe seleccionar 6 Pokémon.");
        }

        // Verificar que cada Pokémon tiene 4 movimientos
        foreach ($_POST['movimientos'] as $movimientos) {
            if (count(array_filter($movimientos)) !== 4) {
                die("Cada Pokémon debe tener 4 movimientos seleccionados.");
            }
        }

        // Comprobar si el equipo ya existe para el usuario
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM equipos WHERE NOMBRE_USUARIO = :nombreUsuario AND NOMBRE_EQUIPO = :nombreEquipo");
        $stmt->execute([':nombreUsuario' => $nombre, ':nombreEquipo' => $nombreEquipo]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            echo "<script>alert('Ya tienes un equipo con este nombre. Por favor elige otro nombre.');</script>";
        } else {
            // Si el equipo no existe, insertar los Pokémon y sus movimientos en la base de datos
            foreach ($pokemonSeleccionados as $index => $idPokemon) {
                if ($idPokemon) {
                    $mov1 = $_POST['movimientos'][$index][1] ?? null;  // Movimiento 1
                    $mov2 = $_POST['movimientos'][$index][2] ?? null;  // Movimiento 2
                    $mov3 = $_POST['movimientos'][$index][3] ?? null;  // Movimiento 3
                    $mov4 = $_POST['movimientos'][$index][4] ?? null;  // Movimiento 4

                    // Insertar en la base de datos
                    $stmt = $pdo->prepare("INSERT INTO equipos (NOMBRE_USUARIO, NOMBRE_EQUIPO, ID_POKEMON, ID_MOVIMIENTO1, ID_MOVIMIENTO2, ID_MOVIMIENTO3, ID_MOVIMIENTO4)
                VALUES (:nombreUsuario, :nombreEquipo, :idPokemon, :mov1, :mov2, :mov3, :mov4)");
                    $stmt->execute([
                        ':nombreUsuario' => $nombre,
                        ':nombreEquipo' => $nombreEquipo,
                        ':idPokemon' => $idPokemon,
                        ':mov1' => $mov1,
                        ':mov2' => $mov2,
                        ':mov3' => $mov3,
                        ':mov4' => $mov4,
                    ]);
                }
            }
            echo "<script>alert('¡Equipo guardado correctamente!');</script>";
        }
    }

    ?>


    <!-- Navbar -->
    <header class="bg-primary text-white">
        <div class="container mx-auto px-1 py-1 flex justify-between items-center">
            <img src="./../assets/images/LOGOTIPO.png" alt="" class="drop-shadow-lg w-20">
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
                //Sólo el rol de administrador tiene acceso a esta sección
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
            //Sólo el rol de administrador tiene acceso a esta sección
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
        <h1 class="text-5xl font-bold text-primary mb-6 py-4">TeamBuilder</h1>

        <form id="team-builder-form" method="POST" class="w-full max-w-4xl bg-white shadow-lg rounded-lg p-6">
            <label class="block mb-4">
                <span class="text-gray-600">Nombre del equipo:</span>
                <input type="text" name="nombre_equipo" required class="w-full mt-1 px-2 py-1 border rounded" />
            </label>
            <div id="team-slots" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php for ($i = 1; $i <= 6; $i++) { ?>
                    <div class="slot border rounded-lg p-4 bg-gray-50">
                        <h2 class="text-lg font-bold text-gray-700">Pokémon <?php echo $i; ?></h2>
                        <label class="block mt-2">
                            <span class="text-gray-600">Selecciona un Pokémon:</span>
                            <div class="pokemon-image">
                                <img src="" alt="Selecciona un Pokémon" class="w-14 h-10 mx-auto hidden" id="pokemon-img-<?php echo $i; ?>">
                            </div>
                            <select name="pokemon[<?php echo $i; ?>]" class="pokemon-select w-full mt-1 px-2 py-1 border rounded">
                                <option value="">Elige un Pokémon</option>
                                <?php foreach ($pokemons as $pokemon) { ?>
                                    <option value="<?php echo $pokemon['ID']; ?>" data-foto="./../assets<?php echo $pokemon['FOTO']; ?>">
                                        <?php echo $pokemon['NOMBRE']; ?> (<?php echo $pokemon['TIPO1']; ?><?php echo $pokemon['TIPO2'] ? "/{$pokemon['TIPO2']}" : ""; ?>)
                                    </option>
                                <?php } ?>
                            </select>
                        </label>
                        <label class="block mt-2">
                            <span class="text-gray-600">Movimientos:</span>
                            <?php for ($j = 1; $j <= 4; $j++) { ?>
                                <select name="movimientos[<?php echo $i; ?>][<?php echo $j; ?>]" class="w-full mt-1 px-2 py-1 border rounded">
                                    <option value="">Selecciona un movimiento</option>
                                    <?php foreach ($movimientos as $movimiento) { ?>
                                        <option value="<?php echo $movimiento['ID']; ?>"><?php echo $movimiento['NOMBRE']; ?> (<?php echo $movimiento['TIPO']; ?>)</option>
                                    <?php } ?>
                                </select>
                            <?php } ?>
                        </label>
                    </div>
                <?php } ?>
            </div>
            <button type="submit" class="bg-primary text-white px-6 py-3 mt-4 rounded-lg shadow-md hover:bg-red-500">Guardar Equipo</button>
        </form>

    </main>

    <!-- Footer -->
    <footer class="bg-primary text-white py-4 text-center">
        Pokémon Team Builder © 2024. Todos los derechos reservados.
    </footer>

    <script>
        // Mostrar imagen y controlar duplicados
        document.querySelectorAll('.pokemon-select').forEach(select => {
            select.addEventListener('change', function() {
                const slot = this.closest('.slot');
                const img = slot.querySelector('.pokemon-image img');
                const selectedOption = this.options[this.selectedIndex];
                const fotoPath = selectedOption.getAttribute('data-foto');

                // Mostrar la imagen solo si hay selección
                if (fotoPath) {
                    img.src = fotoPath;
                    img.classList.remove('hidden'); // Mostrar la imagen
                } else {
                    img.src = "";
                    img.classList.add('hidden'); // Ocultar si no hay selección
                }

                // Evitar duplicados
                const allSelects = document.querySelectorAll('.pokemon-select');
                const selectedValues = Array.from(allSelects).map(s => s.value);

                allSelects.forEach(s => {
                    const options = s.querySelectorAll('option');
                    options.forEach(option => {
                        option.disabled = selectedValues.includes(option.value) && option.value !== s.value;
                    });
                });
            });
        });

        document.getElementById('team-builder-form').addEventListener('submit', function(event) {
            const slots = document.querySelectorAll('.slot');
            let isValid = true;
            let errorMessage = "";

            slots.forEach((slot, index) => {
                const pokemonSelect = slot.querySelector('select[name^="pokemon"]');
                const moveSelects = slot.querySelectorAll('select[name^="movimientos"]');

                if (!pokemonSelect.value) {
                    isValid = false;
                    errorMessage += `Falta seleccionar un Pokémon en el slot ${index + 1}.\n`;
                }

                moveSelects.forEach((moveSelect, moveIndex) => {
                    if (!moveSelect.value) {
                        isValid = false;
                        errorMessage += `Falta seleccionar el movimiento ${moveIndex + 1} para el Pokémon en el slot ${index + 1}.\n`;
                    }
                });
            });

            if (!isValid) {
                event.preventDefault(); // Prevenir el envío del formulario
                alert("Corrija estos errores antes de guardar el equipo:\n" + errorMessage);
            }
        });
    </script>



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