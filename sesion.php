<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: index.php");
    exit();
}

$usuario = $_SESSION["usuario"];
$email = $_SESSION["email"];

$ultima_sesion = $_COOKIE["ultima_sesion"] ?? "";
$sesion_actual = $_COOKIE["sesion_actual"] ?? date("Y-m-d H:i:s");

$upload_dir = "uploads/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["imagenes"])) {
    foreach ($_FILES["imagenes"]["tmp_name"] as $key => $tmp_name) {
        $file_name = basename($_FILES["imagenes"]["name"][$key]);
        $target_file = $upload_dir . $file_name;
        move_uploaded_file($tmp_name, $target_file);
    }
}

if (isset($_GET['delete'])) {
    $file_to_delete = $upload_dir . basename($_GET['delete']);
    if (file_exists($file_to_delete)) {
        unlink($file_to_delete);
    }
    header("Location: sesion.php");
    exit();
}

$imagenes = array_diff(scandir($upload_dir), array('..', '.'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesion iniciada</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="inicio">
        <h1>Bienvenido, <?php echo htmlspecialchars($usuario); ?></h1>
        <p><strong>Correo:</strong> <?php echo htmlspecialchars($email); ?></p>
        <p><strong>Última sesión:</strong> <?php echo htmlspecialchars($ultima_sesion); ?></p>
        <p><strong>Inicio de sesión actual:</strong> <?php echo htmlspecialchars($sesion_actual); ?></p>
        <p style='color: green;'>Has iniciado sesión correctamente.</p>
        
        <h2>Agregar imagen</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="file" name="imagenes[]" multiple>
            <button type="submit">Agregar</button>
        </form>
        
        <h2>Imágenes agregadas</h2>
        <ul>
            <?php foreach ($imagenes as $imagen): ?>
                <li>
                    <img src="<?php echo $upload_dir . $imagen; ?>" width="100" alt="Imagen subida">
                    <p><?php echo htmlspecialchars($imagen); ?></p>
                    <a href="?delete=<?php echo urlencode($imagen); ?>">Eliminar</a>
                </li>
            <?php endforeach; ?>
        </ul>
        
        <button onclick="window.location.href='index.php';">Ir a inicio de sesion</button>
        <button onclick="window.location.href='destruir.php';">Cerrar sesion</button>
    </div>
</body>
</html>