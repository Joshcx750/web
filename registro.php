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

// Procesamiento del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"] ?? "";
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    // Verificamos si el correo ya está registrado
    if (isset($usuarios[$email])) {
        $mensaje = "<p style='color: red;'>El correo ya está registrado.</p>";
    } else {
        // Guardamos el usuario en el archivo JSON
        $usuarios[$email] = [
            "password" => $password,
            "nombre" => $nombre
        ];

        // Guardar los datos actualizados en el archivo JSON
        file_put_contents($file, json_encode($usuarios, JSON_PRETTY_PRINT));

        $mensaje = "<p style='color: green;'>Usuario registrado exitosamente.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="formulario">
        <div class="contenedor2">
            <form action="#" method="POST">
                <h1>Crear cuenta</h1>
                <?php echo $mensaje; ?>
                <div class="cuadro1"></div>
                <input type="text" id="nombre" name="nombre" placeholder="Ingresa nombre" required>
                <input type="email" id="email" name="email" placeholder="udgvirtual@correo.udg.mx" required>
                <input type="password" id="password" name="password" placeholder="password" required>
                <button type="submit">Registrarse</button>
                <button type="button" class="cancel-btn" onclick="window.location.href='index.php';">Cancel</button><br>
                <button type="button" onclick="window.location.href='usuarios.php';">Ver Usuarios Registrados</button>
            </form>
            <form action="archivos.php" method="post" style="margin-top: 20px;">
    <button type="submit">Generar Archivos PDF, DOC, XLS de los usuarios registrados</button>
</form>
<a href="img.php" target="_blank">
    <button type="button">Da click para generar imagen</button>
</a>
        </div>
    </div>
</body>
</html>