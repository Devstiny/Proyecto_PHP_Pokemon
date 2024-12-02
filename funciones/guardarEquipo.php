<?php
include_once '.././funciones/funciones_db.php';
conexion();
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_SESSION['usuario']; // Asegúrate de que el usuario esté autenticado
    $pokemonList = $_POST['pokemon'];
    $movimientosList = $_POST['movimientos'];

    foreach ($pokemonList as $index => $pokemonId) {
        if (empty($pokemonId)) continue;

        $movimientos = $movimientosList[$index];
        guardarEquipo($usuario, "Mi Equipo", $pokemonId, $movimientos);
    }

    header("location: ../pages/equipos.php");
    exit;
}

function guardarEquipo($usuario, $nombreEquipo, $pokemonId, $movimientos)
{
    global $pdo;

    $stmt = $pdo->prepare("INSERT INTO equipos (NOMBRE_USUARIO, NOMBRE_EQUIPO, ID_POKEMON, ID_MOVIMIENTO1, ID_MOVIMIENTO2, ID_MOVIMIENTO3, ID_MOVIMIENTO4) 
        VALUES (?, ?, ?, ?, ?, ?, ?)");
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
