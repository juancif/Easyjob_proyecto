<?php
include_once("config_register.php");

if (isset($_POST['Submit'])) {
    $nombres = $_POST['nombres'];
    $email = $_POST['email'];
    $celular = $_POST['celular'];
    $documento = $_POST['documento'];
    $direccion = $_POST['direccion'];
    $contrasena = $_POST['contrasena'];
    $tipo_usuario = $_POST['tipo_usuario']; // cliente o trabajador

    // Verificar si algún campo está vacío
    if (empty($email) || empty($nombre)  || empty($contrasena) || empty($direccion)) {
        if (empty($email)) {
            echo "<font color='red'>Campo: email está vacío.</font><br/>";
        }
        if (empty($apellido)) {
            echo "<font color='red'>Campo: apellido está vacío.</font><br/>";
        }
        if (empty($contrasena)) {
            echo "<font color='red'>Campo: contraseña está vacío.</font><br/>";
        }
        if (empty($direccion)) {
            echo "<font color='red'>Campo: dirección está vacío.</font><br/>";
        }
        echo "<br/><a href='javascript:self.history.back();'>Volver</a>";
    } else {
        try {
            // Iniciar la transacción
            $dbConn->beginTransaction();

            // Inserción según el tipo de usuario
            if ($tipo_usuario === 'cliente') {
                $sql = "INSERT INTO cliente (nombres, email, celular, documento, direccion, contrasena) 
                        VALUES (:nombres, :email, :celular, :documento, :direccion, :contrasena)";
                $query = $dbConn->prepare($sql);
                $query->bindparam(':nombres', $nombres);
                $query->bindparam(':email', $email);
                $query->bindparam(':celular', $celular);
                $query->bindparam(':documento', $documento);
                $query->bindparam(':direccion', $direccion);
                $query->bindparam(':contrasena', $contrasena); // Asegúrate de usar un hash seguro
            } else if ($tipo_usuario === 'trabajador') {
                $sql = "INSERT INTO trabajador (identificacion, nombre, apellido, direccion, telefono, fecha_nacimiento) 
                        VALUES (:identificacion, :nombre, :apellido, :direccion, :telefono, :fecha_nacimiento)";
                $query = $dbConn->prepare($sql);
                $query->bindparam(':nombre', $nombre);
                $query->bindparam(':identificacion', $identificacion);
                $query->bindparam(':direccion', $direccion);
                $query->bindparam(':telefono', $celular);
                $query->bindparam(':fecha_nacimiento', $fecha_nacimiento);
            }

            $query->execute();

            // Cometer la transacción
            $dbConn->commit();

            if ($query->rowCount() > 0) {
                // Redirigir a la página deseada después del registro exitoso
                header("Location: http://localhost/Easyjob_proyecto/register/registro_exitoso.php");
                exit();
            } else {
                echo "<font color='red'>Error al registrar el usuario o trabajador.</font><br/>";
            }
        } catch (Exception $e) {
            // Revertir los cambios si ocurre un error
            if ($dbConn->inTransaction()) {
                $dbConn->rollBack();
            }
            echo "<font color='black', font-size='40',>Error al registrar: " . $e->getMessage() . "</font><br/>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de cliente o trabajador</title>
    <link rel="stylesheet" href="register_easyjob.css">
</head>
<body>
    <header class="header">
    </header>
    <main class="main-content">
        <div class="register-container">
            <div class="register-box">
                <h2>Registro de cliente o trabajador</h2>
                <form method="post" action="">
                    <div class="input-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="input-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>
                    <div class="input-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" id="apellido" name="apellido" required>
                    </div>
                    <div class="input-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" id="direccion" name="direccion" required>
                    </div>
                    <div class="input-group">
                        <label for="contrasena">Contraseña</label>
                        <input type="password" id="contrasena" name="contrasena" required>
                    </div>
                    <div class="input-group">
                        <label for="tipo_usuario">Tipo de Usuario</label>
                        <select name="tipo_usuario" id="tipo_usuario" required>
                            <option value="cliente">Cliente</option>
                            <option value="trabajador">Trabajador</option>
                        </select>
                    </div>
                    
                    <!-- Campos adicionales si es cliente -->
                    <div id="campos_cliente" style="display:none;">
                        <div class="input-group">
                            <label for="celular">Celular</label>
                            <input type="text" id="celular" name="celular">
                        </div>
                        <div class="input-group">
                            <label for="documento">Documento</label>
                            <input type="text" id="documento" name="documento">
                        </div>
                    </div>
                    
                    <!-- Campos adicionales si es trabajador -->
                    <div id="campos_trabajador" style="display:none;">
                        <div class="input-group">
                            <label for="identificacion">Identificación</label>
                            <input type="text" id="identificacion" name="identificacion">
                        </div>
                        <div class="input-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" id="telefono" name="telefono">
                        </div>
                        <div class="input-group">
                            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento">
                        </div>
                    </div>

                    <div class="buttons">
                        <input type="submit" name="Submit" value="Registrarse" class="Registrarse">
                        <a href="http://localhost/Easyjob_proyecto/login/login_easyjob.php" class="regresar">Regresar</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <footer class="footer">
        <p><a href="#">Ayuda</a> | <a href="#">Términos de servicio</a></p>
        <script>
            // Mostrar los campos según el tipo de usuario seleccionado
            document.getElementById('tipo_usuario').addEventListener('change', function() {
                var tipo = this.value;
                if (tipo === 'cliente') {
                    document.getElementById('campos_cliente').style.display = 'block';
                    document.getElementById('campos_trabajador').style.display = 'none';
                } else if (tipo === 'trabajador') {
                    document.getElementById('campos_cliente').style.display = 'none';
                    document.getElementById('campos_trabajador').style.display = 'block';
                } else {
                    document.getElementById('campos_cliente').style.display = 'none';
                    document.getElementById('campos_trabajador').style.display = 'none';
                }
            });
        </script>
    </footer>
</body>
</html>









