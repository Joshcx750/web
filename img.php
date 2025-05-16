<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "Usuario";
    
    
    $ancho = 400;
    $alto = 200;
    $imagen = imagecreatetruecolor($ancho, $alto);
    
    
    $blanco = imagecolorallocate($imagen, 227, 238, 238);
    $negro = imagecolorallocate($imagen, 0, 0, 0);
    
    
    imagefilledrectangle($imagen, 0, 0, $ancho, $alto, $blanco);
    
   
    $fuente = 5; 
    $x = ($ancho - imagefontwidth($fuente) * strlen($nombre)) / 2;
    $y = ($alto - imagefontheight($fuente)) / 2;
    imagestring($imagen, $fuente, $x, $y, $nombre, $negro);
    
   
    header("Content-Type: image/png");
    imagepng($imagen);
    
    
    imagedestroy($imagen);
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actividad 3.2</title>
</head>
<body>
    <form action="" method="POST">
        <label for="nombre">Ingresa tu nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <button type="submit">Generar imagen</button>
    </form>
    <button onclick="window.location.href='index.php';">Ir a inicio de sesion</button>
</body>
</html>