<?php
include_once("config_gestor_index.php");

    // Obtener el resultado de la consulta
    $trabajador = $query->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontraron resultados
    if ($trabajador) {
        // El trabajador existe y se pueden mostrar sus datos
        $nombresApellidos = htmlspecialchars($trabajador['nombres_apellidos']);
        $celular = htmlspecialchars($trabajador['celular']);
        $email = htmlspecialchars($trabajador['email']);
        $labor = htmlspecialchars($trabajador['labor']);
    } 
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="trabajador.css">
</head>
<body>
    <div class="titulo_detalle">
        <h2 class="texto_detalle">Editar perfil usuario</h2>
    </div>
    <div class="detalle_fondo">
        <form action="procesar_actualizacion.php" method="POST">
            <div class="form-group">
                <label for="nombres_apellidos"><strong>Nombre:</strong></label>
                <input type="text" id="nombres_apellidos" name="nombres_apellidos" value="<?php echo htmlspecialchars($nombres_apellidos); ?>" required>
            </div>

            <div class="form-group">
                <label for="email"><strong>Correo electrónico:</strong></label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
    
            <div class="form-group">
                <label for="celular"><strong>Celular:</strong></label>
                <input type="tel" id="celular" name="celular" value="<?php echo htmlspecialchars($celular); ?>" required>
            </div>

            <div class="form-group">
                <label for="labor"><strong>Trabajo:</strong></label>
                <input type="text" id="labor" name="labor" value="<?php echo htmlspecialchars($labor); ?>" required>
            </div>
    
            <div class="form-group">
                <label for="contrasena."><strong>Conatr</strong></label>
                <textarea id="descripcion" name="descripcion" rows="4" placeholder="Agregar más detalles sobre el trabajador"></textarea>
            </div>

            <div class="form-group">
                <label for="descripcion"><strong>Descripción:</strong></label>
                <textarea id="descripcion" name="descripcion" rows="4" placeholder="Agregar más detalles sobre el trabajador"></textarea>
            </div>
    
            <!-- Botón que redirige a WhatsApp -->
            <div class="form-group">
                <label for="whatsapp"><strong>WhatsApp:</strong></label>
                <a href="https://wa.me/<?php echo preg_replace('/\D/', '', $celular); ?>" target="_blank">Contactar por WhatsApp</a>
            </div>
    
            <!-- Botón para enviar los datos actualizados -->
            <button type="submit" class="boton_guardar">Guardar Cambios</button>
        </form>
    
        <!-- Botón para regresar a la pantalla anterior -->
        <button class="boton_regresar" onclick="history.back();">Regresar</button>
    </div>
    
</body>
</html>
