<?php
session_start();
date_default_timezone_set('America/Mexico_City');
$mensaje = "";

// Ruta al archivo JSON
$file = 'usuario.json';

// Si el archivo JSON no existe, crearlo con el usuario predeterminado
if (!file_exists($file)) {
    $usuarios = [
        "udgvirtual@correo.udg.mx" => [
            "password" => "123456",
            "nombre" => "Usuario Predeterminado"
        ]
    ];
    file_put_contents($file, json_encode($usuarios, JSON_PRETTY_PRINT));
} else {
    // Leer el archivo JSON
    $usuarios = json_decode(file_get_contents($file), true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    // Verificar si el usuario existe en el archivo JSON
    if (isset($usuarios[$email])) {
        $usuario = $usuarios[$email];
        if ($usuario["password"] === $password) {
            $_SESSION["usuario"] = $usuario["nombre"];
            $_SESSION["email"] = $email;

            // Manejo de cookies para la sesión
            if (isset($_COOKIE["sesion_actual"])) {
                setcookie("ultima_sesion", $_COOKIE["sesion_actual"], time() + (365 * 24 * 60 * 60), "/");
            }
            setcookie("sesion_actual", date("Y-m-d H:i:s"), time() + (365 * 24 * 60 * 60), "/");

            header("Location: sesion.php");
            exit();
        } else {
            $mensaje = "<p style='color: red;'>Correo o contraseña incorrecto.</p>";
        }
    } else {
        $mensaje = "<p style='color: red;'>El usuario no está registrado.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="formulario">
        <div class="cuadro"></div>
        <div class="contenedor2">
            <form action="#" method="POST">
                <h1>Iniciar sesion en</h1>
                <h1>windows live Messenger</h1>
                <?php echo $mensaje; ?>
                <input type="email" name="email" placeholder="Correo electrónico" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <button type="submit">Sign in</button>
                <p>¿No tienes una cuenta? <a href="registro.php">Registrarse</a>.</p>
            </form>
        </div>
    </div>
</body>
</html>