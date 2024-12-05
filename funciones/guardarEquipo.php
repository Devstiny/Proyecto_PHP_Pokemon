<?php

/**
 * Archivo para gestionar la creación de equipos de Pokémon.
 * Incluye funcionalidades para guardar equipos en la base de datos.
 */
include_once '.././funciones/funciones_db.php';
conexion();
session_start();

/**
 * Controlador principal: Verifica el método de solicitud y procesa los datos enviados por el formulario.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /**
     * @var string $usuario El nombre de usuario autenticado, obtenido de la sesión.
     * @var array $pokemonList Lista de IDs de Pokémon enviada desde el formulario.
     * @var array $movimientosList Lista de movimientos asociados a cada Pokémon.
     */
    $usuario = $_SESSION['usuario'];
    $pokemonList = $_POST['pokemon'];
    $movimientosList = $_POST['movimientos'];

    // Recorre la lista de Pokémon y sus movimientos para guardarlos.
    foreach ($pokemonList as $index => $pokemonId) {
        // Si no hay un Pokémon en esta posición, pasa al siguiente.
        if (empty($pokemonId)) continue;

        // Obtiene los movimientos correspondientes a este Pokémon.
        $movimientos = $movimientosList[$index];
        guardarEquipo($usuario, "Mi Equipo", $pokemonId, $movimientos);
    }
    // Redirige a la página de equipos tras procesar los datos.
    header("location: ../pages/equipos.php");
    exit;
}

/**
 * Guarda un Pokémon con sus movimientos en un equipo para el usuario.
 *
 * @param string $usuario       Nombre del usuario que crea el equipo.
 * @param string $nombreEquipo  Nombre del equipo.
 * @param int $pokemonId        ID del Pokémon que se añadirá al equipo.
 * @param array $movimientos    Array de movimientos asociados al Pokémon (pueden ser 1-4).
 *
 * @return void
 */
function guardarEquipo($usuario, $nombreEquipo, $pokemonId, $movimientos)
{
    global $pdo; // Objeto PDO para manejar la base de datos.

    // Prepara la consulta SQL para insertar un registro en la tabla de equipos.
    $stmt = $pdo->prepare("INSERT INTO equipos (NOMBRE_USUARIO, NOMBRE_EQUIPO, ID_POKEMON, ID_MOVIMIENTO1, ID_MOVIMIENTO2, ID_MOVIMIENTO3, ID_MOVIMIENTO4) 
        VALUES (?, ?, ?, ?, ?, ?, ?)");
    // Ejecuta la inserción con los valores proporcionados.
    $stmt->execute([
        $usuario,
        $nombreEquipo,
        $pokemonId,
        $movimientos[1] ?? null,
        $movimientos[2] ?? null,
        $movimientos[3] ?? null,
        $movimientos[4] ?? null
    ]);
}
