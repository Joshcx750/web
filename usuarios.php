<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Usuarios Registrados</h1>
    
    <?php
    // Ruta al archivo JSON
    $file = 'usuario.json';

    // Verificar si el archivo JSON existe
    if (file_exists($file)) {
        // Leer el archivo JSON
        $usuarios = json_decode(file_get_contents($file), true);

        // Verificar si hay usuarios registrados
        if (!empty($usuarios)): ?>
            <table border="1">
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                </tr>
                <?php foreach ($usuarios as $email => $datos): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($datos["nombre"]); ?></td>
                        <td><?php echo htmlspecialchars($email); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No hay usuarios registrados.</p>
        <?php endif;
    } else {
        echo "<p>No hay usuarios registrados.</p>";
    }
    ?>

    <br>
    
    <div class="botones">
        <button onclick="window.location.href='registro.php';">Registrar Nuevo Usuario</button>
        <button onclick="window.location.href='index.php';">Ir a inicio de sesion</button>
      
    </div>
</body>
</html>