<?php

/**
 * Establece una conexión con la base de datos MySQL usando PDO.
 *
 * @return void
 */
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

/**
 * Inicia sesión validando el nombre de usuario y la contraseña.
 * Si el inicio de sesión es correcto, genera un token y lo guarda en la sesión.
 *
 * @return string Mensaje de error si las credenciales son incorrectas.
 */
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

/**
 * Obtiene los datos del usuario a partir del token de sesión.
 *
 * @param string $token El token de sesión del usuario.
 * @return array|null Los datos del usuario si se encuentra, de lo contrario, null.
 */
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

/**
 * Registra un nuevo usuario en la base de datos si no existe ya con el mismo nombre o correo.
 *
 * @param string $nombreUsuario Nombre del nuevo usuario.
 * @param string $correo Correo electrónico del nuevo usuario.
 * @param string $password Contraseña del nuevo usuario.
 * @return string Mensaje de error si la inserción falla, vacío si se realiza con éxito.
 */
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


/**
 * Modifica el nombre de usuario del usuario logueado en la base de datos.
 *
 * @return void
 */
function cambiarUsu()
{
    global $pdo;
    $consulta = "UPDATE USUARIOS SET NOMBRE_USUARIO = :nombre WHERE TOKEN = :token";
    $stmt = $pdo->prepare($consulta);
    $stmt->bindParam(':token', $_SESSION['token'], PDO::PARAM_STR);
    $stmt->bindParam(':nombre', $_POST['usu'], PDO::PARAM_STR);
    $stmt->execute();
}

/**
 * Actualiza el correo electrónico del usuario logueado en la base de datos.
 *
 * @return void
 */
function cambiarMail()
{
    global $pdo;
    $consulta = "UPDATE USUARIOS SET MAIL = :mail WHERE TOKEN = :token";
    $stmt = $pdo->prepare($consulta);
    $stmt->bindParam(':token', $_SESSION['token'], PDO::PARAM_STR);
    $stmt->bindParam(':mail', $_POST['mail'], PDO::PARAM_STR);
    $stmt->execute();
}

/**
 * Actualiza la contraseña del usuario logueado en la base de datos.
 *
 * @return void
 */
function cambiarPass()
{
    global $pdo;
    $pass = $_POST['pass'];
    $encryptedPassword = password_hash($pass, PASSWORD_DEFAULT);
    $consulta = "UPDATE USUARIOS SET PASSWORD = :pass WHERE TOKEN = :token";
    $stmt = $pdo->prepare($consulta);
    $stmt->bindParam(':token', $_SESSION['token'], PDO::PARAM_STR);
    $stmt->bindParam(':pass', $encryptedPassword, PDO::PARAM_STR);
    $stmt->execute();
}

/**
 * Obtiene todos los Pokémon de la pokedex desde la base de datos.
 *
 * @return array Lista de Pokémon de la pokedex.
 */
function getPokedex()
{
    global $pdo;
    $stmt = $pdo->query("SELECT ID, NOMBRE, TIPO1, TIPO2, FOTO FROM pokedex");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Obtiene todos los movimientos disponibles desde la base de datos.
 *
 * @return array Lista de movimientos.
 */
function getMovimientos()
{
    global $pdo;
    $stmt = $pdo->query("SELECT ID, NOMBRE, TIPO FROM movimientos");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Muestra los movimientos de la base de datos en formato de tabla HTML.
 *
 * @return void
 */
function mostrarMoves()
{
    global $pdo;
    $consulta = "SELECT * FROM `movimientos`;";
    $stmt = $pdo->prepare($consulta);
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $resultado;
}

/**
 * Convierte los datos de movimientos en filas de una tabla HTML.
 *
 * @param array $datos Datos de los movimientos.
 * @return void
 */
function converTablaMoves($datos)
{
    foreach ($datos as $key) {
        echo "<tr>";
        foreach ($key as $k => $valor) {
            if ($k != "ID") {
                if ($k == 'DESCRIPCION')
                    echo "<td class='text-start p-2 border border-[#D33F5A]'>$valor</td>";
                else
                    echo "<td class='border border-[#D33F5A]'>$valor</td>";
            }
        }
        echo "</tr>";
    }
}

/**
 * Muestra los Pokémon de la base de datos en formato de tabla HTML.
 *
 * @return void
 */
function mostrarPokes()
{
    global $pdo;
    $consulta = "SELECT * FROM `pokedex`;";
    $stmt = $pdo->prepare($consulta);
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $resultado;
}

/**
 * Convierte los datos de Pokémon en filas de una tabla HTML.
 *
 * @param array $datos Datos de los Pokémon.
 * @return void
 */
function converTablaPoke($datos)
{
    foreach ($datos as $key) {
        echo "<tr>";
        foreach ($key as $k => $valor) {
            if ($k != "FOTO") {
                ($valor == "") ? $valor = "-" : $valor;
                echo "<td class='border border-[#D33F5A]'>$valor</td>";
            } else {
                echo "<td class='border border-[#D33F5A]'><img class='w-8 mx-auto hover:w-36 hover:transition-all hover:duration-500' src='.././assets$valor'></td>";
            }
        }
        echo "</tr>";
    }
}

/**
 * Genera vistas HTML para equipos de Pokémon.
 *
 * Divide los equipos en grupos de hasta 6 elementos, los muestra en una tarjeta con opciones
 * para cambiar el nombre del equipo, visualizar los Pokemons en el equipo y eliminarlos.
 * 
 * Al nombre del equipo se le sustituyen los espacios por '_' para evitar la perdida de datos, ya que al pasarlo por el metodo post y luego compararlo solo coge los caracteres hasat encontrarse el primer espacio y entonces la comparacion para hacer updaye en la base de datos es erroena, para luego compararlo bien en la pagina cambiarNombreEquipo se vuelven a reemplazar los '_' por espacios.
 *
 * @param array $equipos Array con datos de los equipos.
 * @return void
 */
function agregarVistaEquipos($equipos){
    $veces = count($equipos) / 6;
    if($veces > 1){
        $subarray = array_chunk($equipos, 6);
    }
    for($i = 0; $i < $veces; $i++){
        if(isset($subarray)){
            $aux = $subarray[$i];
            $aux1 = $aux[0];
        }else{
            $aux = $equipos;
            $aux1 = $aux[0];
        }
        
        echo "<div class='w-full max-w-4xl bg-white shadow-lg rounded-lg p-6 mb-4'>
            <label class='block mb-4'>
                <span class='text-black font-bold'>Nombre del equipo: ".  $aux1['NOMBRE_EQUIPO'] ."</span>
                <form action='.././funciones/cambiarNombreEquipo.php' method='post' class='flex justify-evenly  mt-4'>
                    <label class='p-2 w-64 text-end font-semibold' for='nom'>Nuevo Nombre:</label>
                    <input type='text' name='nom' class='p-2 w-64'>
                    <input type='hidden' name='nom_act' class='p-2 w-64' value=". str_replace(' ', '_', $aux1['NOMBRE_EQUIPO'])  .">
                    <button class='p-2 rounded-lg bg-primary hover:bg-red-500 text-white w-64'>Actualizar Nombre <i class='fa-solid fa-arrows-rotate px-2'></i></button>
                </form>
            </label>
            <div id='team-slots' class='grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4'>";
                 foreach( ((isset($subarray))? $subarray[$i] : $equipos) as $equipo){ 
                    $foto = cargarFotoConsulta($equipo['ID_POKEMON']);
                    $nom = cargarNombreConsulta($equipo['ID_POKEMON']);
                 echo  "<div class='slot border rounded-lg p-4 bg-gray-50'>
                        <h2 class='text-lg font-bold text-gray-700'> $nom </h2>
                            <div class='pokemon-image'>
                                <img src='.././assets$foto' alt='Selecciona un Pokémon' class='w-7xl h-10 mx-auto' id='pokemon-img-"; echo $i; echo"'><!-- añadir src desde la base de datos -->
                            </div>
                           
                        
                    </div>";
                } 
           echo "</div>
            <form action='#' method='post'>
                <input type='hidden' name='nombre_equipo' value='".$aux1['NOMBRE_EQUIPO']."'>
                <button type='submit' class='bg-primary text-white px-6 py-3 mt-4 rounded-lg shadow-md hover:bg-red-500'>Eliminar Equipo<i class='fa-regular fa-trash-can mx-2'></i></button>
            </form>
        </div>";
    }
}


/**
 * Carga los equipos de un usuario específico desde la base de datos y los envía a la función
 * que genera las vistas HTML correspondientes. Si no hay equipos, muestra un mensaje informativo.
 *
 * @param string $nombre Nombre del usuario.
 * @return void
 */
function cargarEquiposUsu($nombre){
    global $pdo;
    $consulta = "SELECT NOMBRE_EQUIPO, ID_POKEMON, ID_MOVIMIENTO1, ID_MOVIMIENTO2, ID_MOVIMIENTO3, ID_MOVIMIENTO4 FROM equipos WHERE NOMBRE_USUARIO LIKE :usu";
    $stmt = $pdo->prepare($consulta);
    $stmt->bindParam(':usu', $nombre);
    $stmt->execute();
    $equipos = $stmt->fetchAll();
    ($equipos != [])? agregarVistaEquipos($equipos) : sinEquipos();
    
}


/**
 * Muestra un mensaje indicando que no hay equipos creados y proporciona un enlace
 * para crear un nuevo equipo.
 *
 * @return void
 */
function sinEquipos(){
    echo '<p class="text-lg text-gray-700 mb-8 max-w-md">
            Aún no has creado ningún equipo.
        </p>
        <div class="flex space-x-4">
            <a href=".././pages/teamBuilder.php" class="bg-primary text-white px-6 py-3 rounded-lg shadow-md hover:bg-red-500">
                Crear Equipo
            </a>
        </div>';
}


/**
 * Obtiene la foto de un Pokémon desde la base de datos según su ID.
 *
 * @param int $id ID del Pokémon en la base de datos.
 * @return string URL o ruta de la foto del Pokémon.
 */
function cargarFotoConsulta($id) {
    global $pdo;
    $consulta = "SELECT FOTO FROM POKEDEX WHERE ID = :id";
    $stmt = $pdo->prepare($consulta);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
    $stmt->execute();
    $foto = $stmt->fetch(PDO::FETCH_ASSOC);
    return $foto['FOTO'];
}


/**
 * Obtiene el nombre de un Pokémon desde la base de datos según su ID.
 *
 * @param int $id ID del Pokémon en la base de datos.
 * @return string Nombre del Pokémon.
 */
function cargarNombreConsulta($id) {
    global $pdo;
    $consulta = "SELECT NOMBRE FROM POKEDEX WHERE ID = :id";
    $stmt = $pdo->prepare($consulta);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
    $stmt->execute();
    $nombre = $stmt->fetch(PDO::FETCH_ASSOC);
    return $nombre['NOMBRE'];
}


/**
 * Elimina un equipo de Pokemons de la base de datos según su nombre.
 *
 * @param string $nombreEquipo Nombre del equipo que se desea eliminar.
 * @return void
 */
function eliminarEquipo($nombreEquipo){
    global $pdo;
    $consulta = "DELETE FROM equipos WHERE NOMBRE_EQUIPO LIKE :nombre";
    $stmt = $pdo->prepare($consulta);
    $stmt->bindParam(':nombre', $nombreEquipo ); 
    $stmt->execute();
}


/**
 * Genera una tabla HTML con la lista de usuarios (excluyendo al usuario 'admin'),
 * mostrando su nombre, correo, rol, y la cantidad de equipos asociados.
 * Además, incluye formularios para cambiar el rol o eliminar a un usuario.
 *
 * @global PDO $pdo Conexión a la base de datos mediante PDO.
 * @return void
 */
function tablaUsuarios(){
    global $pdo;
    $consulta = "SELECT u.NOMBRE_USUARIO, u.MAIL, u.ROL, COUNT(DISTINCT e.NOMBRE_EQUIPO) AS TOTAL_EQUIPOS FROM usuarios u LEFT JOIN equipos e  ON u.NOMBRE_USUARIO = e.NOMBRE_USUARIO WHERE u.NOMBRE_USUARIO != 'admin' GROUP BY u.NOMBRE_USUARIO;";
    $stmt = $pdo->prepare($consulta);
    $stmt->execute();
    $usuarios = $stmt->fetchAll();
    
    foreach($usuarios as $usu){
        echo "<tr>
            <td class='border px-4'>".$usu['NOMBRE_USUARIO']."</td>
            <td class='border px-4'>".$usu['MAIL']."</td>
            <td class='border px-4'>".$usu['ROL']."</td>
            <td class='border px-4'>".$usu['TOTAL_EQUIPOS']."</td>
            <td> 
            <form action='.././funciones/administrarUsu.php' method='post'>
                <input type='hidden' name='nom' value='".$usu["NOMBRE_USUARIO"]."'> 
                <input type='hidden' name='rol' value='".$usu["ROL"]."'> 
                <button type='submit' name='action' class='bg-primary hover:bg-red-500 p-2 m-2 text-white rounded-lg'> Cambiar Rol <i class='fa-solid fa-a mx-2'></i></button>
            </form>
        </td>
        <td> 
            <form action='.././funciones/administrarUsu.php' method='post'>
                <input type='hidden' name='del' value='".$usu["NOMBRE_USUARIO"]."'> 
                <button type='submit' name='action' class='bg-primary hover:bg-red-500 p-2 m-2 text-white rounded-lg'><i class='fa-regular fa-trash-can mx-2'></i></button> 
            </form>
        </td>
        </tr>";
    }

}


/**
 * Cambia el rol de un usuario entre 'R' (Registrado) y 'A' (Administrador).
 *
 * @param string $nombre Nombre del usuario cuyo rol se desea cambiar.
 * @param string $rol Rol actual del usuario ('R' o 'A').
 * @return void
 */
function cambiarRol($nombre, $rol){
    $rol = ($rol == 'R')? 'A': 'R';
    global $pdo;
    $consulta = "UPDATE usuarios SET ROL = :rol WHERE NOMBRE_USUARIO = :nombre";
    $stmt = $pdo->prepare($consulta);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':rol', $rol);
    $stmt->execute();
}


/**
 * Elimina un usuario de la base de datos según su nombre de usuario.
 *
 * @param string $nombre Nombre del usuario que se desea eliminar.
 * @return void
 */
function eliminarUsu($nombre){
    global $pdo;
    $consulta="DELETE FROM usuarios WHERE NOMBRE_USUARIO = :nombre";
    $stmt = $pdo->prepare($consulta);
    $stmt -> bindParam(':nombre', $nombre);
    $stmt -> execute();
}


/**
 * Cambia el nombre de un equipo en la base de datos.
 *
 * @param string $nomAct Nombre actual del equipo.
 * @param string $nomNew Nuevo nombre del equipo.
 * @return void
 */
function cambiarNombreEquipo($nomAct, $nomNew){
    global $pdo;
    $consulta = "UPDATE equipos SET NOMBRE_EQUIPO = :nomNew WHERE NOMBRE_EQUIPO = :nomAct";
    $stmt = $pdo -> prepare($consulta);
    $stmt -> bindParam(':nomAct', $nomAct);
    $stmt -> bindParam(':nomNew', $nomNew);
    $stmt -> execute();
}