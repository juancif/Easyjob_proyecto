<?php
include_once("config_register.php");

if (isset($_POST['Submit'])) {
    $nombres = $_POST['nombres'];
    $email = $_POST['email'];
    $celular = $_POST['celular'];
    $contrasena = $_POST['contrasena'];

    // Verificar si algún campo está vacío
    if (empty($nombres) || empty($email) || empty($celular) || empty($contrasena)) {
        if (empty($nombres)) {
            echo "<font color='red'>Campo: nombres está vacío.</font><br/>";
        }
        if (empty($email)) {
            echo "<font color='red'>Campo: email está vacío.</font><br/>";
        }
        if (empty($celular)) {
            echo "<font color='red'>Campo: celular está vacío.</font><br/>";
        }
        if (empty($contrasena)) {
            echo "<font color='red'>Campo: contraseña está vacío.</font><br/>";
        }
        echo "<br/><a href='javascript:self.history.back();'>Volver</a>";
    } else {
        // Hashear la contraseña para mayor seguridad
        $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

        // Consulta SQL para insertar los datos en la tabla cliente
        $sql = "INSERT INTO cliente (nombres, email, celular, contrasena) 
                VALUES (:nombres, :email, :celular, :contrasena)";
        $query = $dbConn->prepare($sql);

        // Vincular los parámetros con los valores ingresados
        $query->bindparam(':nombres', $nombres);
        $query->bindparam(':email', $email);
        $query->bindparam(':celular', $celular);
        $query->bindparam(':contrasena', $hashed_password);

        // Ejecutar la consulta
        if ($query->execute()) {
            // Redirigir a la página de registro exitoso
            header("Location: http://localhost/Easyjob_proyecto/register/registro_exitoso.php");
            exit();
        } else {
            echo "<font color='red'>Error al registrar el usuario.</font><br/>";
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
                        <label for="nombres">Nombres y Apellidos</label>
                        <input type="text" id="nombres" name="nombres" required>
                    </div>
                    <div class="input-group">
                        <label for="email">Correo electronico</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="input-group">
                        <label for="celular">Celular</label>
                        <input type="number" id="celular" name="celular" required>
                    </div>
                    <div class="input-group tooltip">
                        <label for="contrasena">Contraseña</label>
                        <input type="password" id="contrasena" name="contrasena" required>
                        <span class="tooltiptext">Recuerda que la contraseña debe tener mínimo 12 caracteres, un carácter especial y una mayúscula.</span>
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
    </footer>
</body>
</html>
