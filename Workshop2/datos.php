<?php
// Inicializamos mensaje vacío
$mensaje = "";

// Verificamos si se enviaron datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Datos de conexión a la base de datos
    $host = "localhost";
    $usuario = "root";
    $password = ""; // Cambia si tienes contraseña
    $base_de_datos = "bade_datos_workshop2";

    // Conexión a la base de datos
    $conexion = new mysqli($host, $usuario, $password, $base_de_datos);

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];

    // Preparar la consulta SQL
    $stmt = $conexion->prepare("INSERT INTO contactos (nombre, apellido, correo, telefono) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $apellido, $correo, $telefono);

    // Ejecutar la consulta y generar mensaje
    if ($stmt->execute()) {
        $mensaje = "Datos insertados correctamente.";
    } else {
        $mensaje = "Error al insertar datos: " . $stmt->error;
    }

    // Cerrar la conexión
    $stmt->close();
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Contacto</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

   <div class="form-container">
        <h2 class="form-title">Formulario de Contacto</h2>
    <?php
    // Mostrar mensaje si existe
    if ($mensaje != "") {
        echo "<p><strong>$mensaje</strong></p>";
    }
    ?>
        <form action="" method="post">
    <div class="input-group">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" required>
    </div>
    
    <div class="input-group">
        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" name="apellido" required>
    </div>
    
    <div class="input-group">
        <label for="correo">Correo Electrónico</label>
        <input type="email" id="correo" name="correo" required>
    </div>
    
    <div class="input-group">
        <label for="telefono">Teléfono</label>
        <input type="tel" id="telefono" name="telefono" required>
    </div>
    
    <div class="separator"></div>
    
    <button type="submit" class="btn-submit">Enviar</button>
</form>

    </div>
</body>
</html>
