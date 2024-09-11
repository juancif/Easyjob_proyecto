<?php
include_once("config_gestor.php");

// Verificar si el parámetro 'id' está presente en la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta SQL para obtener los detalles del trabajador
    $sql = "SELECT nombres_apellidos, celular, email, labor FROM trabajador WHERE id = :id AND rol = 'trabajador'";
    $query = $dbConn->prepare($sql);
    
    // Ejecutar la consulta con el parámetro seguro
    $query->execute([':id' => $id]);

    // Obtener el resultado de la consulta
    $trabajador = $query->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontraron resultados
    if ($trabajador) {
        // El trabajador existe y se pueden mostrar sus datos
        $nombresApellidos = htmlspecialchars($trabajador['nombres_apellidos']);
        $celular = htmlspecialchars($trabajador['celular']);
        $email = htmlspecialchars($trabajador['email']);
        $labor = htmlspecialchars($trabajador['labor']);
    } else {
        echo "No se encontró el trabajador con el ID especificado.";
        exit; // Terminar el script
    }
} else {
    echo "ID de trabajador no especificado.";
    exit; // Terminar el script
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Trabajador</title>
    <link rel="stylesheet" href="trabajador.css">
</head>
<body>
    <div class=titulo_detalle><h2 class="texto_detalle">Detalles del Trabajador</h2></div>
    <div class="detalle_fondo">
        <p><strong>Nombre:</strong> <?php echo $nombresApellidos; ?></p>
        <p><strong>Celular:</strong> <?php echo $celular; ?></p>
        <p><strong>Correo electrónico:</strong> <?php echo $email; ?></p>
        <p><strong>Trabajo:</strong> <?php echo $labor; ?></p>
        <p><strong>Descripción:</strong> Aquí puedes agregar más detalles sobre el trabajador.</p>

        <!-- Botón que redirige a WhatsApp -->
        <a href="https://wa.me/<?php echo preg_replace('/\D/', '', $celular); ?>" target="_blank">Contactar</a>
    </div>
</body>
</html>
