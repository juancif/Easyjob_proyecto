<?php
include_once("config_register.php");

if (isset($_POST['Submit'])) {
    $nombres_apellidos = $_POST['nombres_apellidos'];
    $email = $_POST['email'];
    $celular = $_POST['celular'];
    $contrasena = $_POST['contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];
    $rol = $_POST['rol'];
    $labor = isset($_POST['labor']) ? $_POST['labor'] : null;

    // Verificar si algún campo está vacío
    if (empty($nombres_apellidos) || empty($email) || empty($celular) || empty($contrasena) || empty($confirmar_contrasena)  || empty($rol)) {
        if (empty($nombres_apellidos)) {
            echo "<font color='red'>Campo: nombres_apellidos está vacío.</font><br/>";
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
        if (empty($confirmar_contrasena)) {
            echo "<font color='red'>Campo: confirmar_contrasena está vacío.</font><br/>";
        }
        if (empty($rol)) {
            echo "<font color='red'>Campo: rol está vacío.</font><br/>";
        }
        echo "<br/><a href='javascript:self.history.back();'>Volver</a>";
    } else {

            // Verificar si las contraseñas coinciden
            if ($contrasena !== $confirmar_contrasena) {
                echo "<font color='red'>Las contraseñas no coinciden.</font><br/>";
                echo "<br/><a href='javascript:self.history.back();'>Volver</a>";
                exit();
            }
        // Hashear la contraseña para mayor seguridad
        $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

        // Dependiendo del rol, insertar en la tabla correspondiente
        if ($rol === 'trabajador') {
            $sql = "INSERT INTO trabajador (nombres_apellidos, email, celular, contrasena, labor, rol) 
                    VALUES (:nombres_apellidos, :email, :celular, :contrasena, :labor, :rol)";
            $query = $dbConn->prepare($sql);
            $query->bindparam(':labor', $labor);
        } elseif ($rol === 'admin') {
            $sql = "INSERT INTO admin (nombres_apellidos, email, celular, contrasena, rol) 
                    VALUES (:nombres_apellidos, :email, :celular, :contrasena, :rol)";
            $query = $dbConn->prepare($sql);
        } elseif ($rol === 'usuario') {
            $sql = "INSERT INTO usuario (nombres_apellidos, email, celular, contrasena, rol) 
                    VALUES (:nombres_apellidos, :email, :celular, :contrasena, :rol)";
            $query = $dbConn->prepare($sql);
        } else {
            echo "<font color='red'>Rol no válido.</font><br/>";
            exit();
        }

        // Vincular los parámetros con los valores ingresados
        $query->bindparam(':nombres_apellidos', $nombres_apellidos);
        $query->bindparam(':email', $email);
        $query->bindparam(':celular', $celular);
        $query->bindparam(':contrasena', $hashed_password);
        $query->bindparam(':rol', $rol);

        // Ejecutar la consulta
        if ($query->execute()) {
            // Redirigir a la página de registro exitoso
            header("Location: registro_exitoso.php");
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
    <title>Registro de usuario o trabajador</title>
    <link rel="stylesheet" href="register_easyjob.css">
    <script>
        function toggleLaborField() {
            var rol = document.getElementById('rol').value;
            var laborField = document.getElementById('labor-field');
            if (rol === 'trabajador') {
                laborField.style.display = 'block';
            } else {
                laborField.style.display = 'none';
            }
        }

        function validateForm() {
            var emailField = document.getElementById('email');
            var emailValue = emailField.value;
            var passwordField = document.getElementById('contrasena');
            var confirmPasswordField = document.getElementById('confirmar_contrasena');
            var passwordValue = passwordField.value;
            var confirmPasswordValue = confirmPasswordField.value;

            // // Verificar si el correo electrónico tiene el dominio específico
            // if (!emailValue.endsWith('@')) {
            //     alert('El correo electrónico debe tener el dominio "@"');
            //     return false; // Evita el envío del formulario
            // }

            // Verificar si las contraseñas coinciden
            if (passwordValue !== confirmPasswordValue) {
                alert('Las contraseñas no coinciden.');
                return false; // Evita el envío del formulario
            }

            return true; // Permite el envío del formulario
        }
    </script>
</head>
<body>
    <header class="header"></header>
    <main class="main-content">
        <div class="register-container">
            <div class="register-box">
                <h2>Registro de usuario o trabajador</h2>
                <form method="post" action="" onsubmit="return validateForm()">
                    <div class="input-group">
                        <label for="nombres_apellidos">Nombres y Apellidos</label>
                        <input type="text" id="nombres_apellidos" name="nombres_apellidos" required>
                    </div>
                    <div class="input-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="input-group">
                        <label for="celular">Celular</label>
                        <input type="number" id="celular" name="celular" required>
                    </div>
                    <div class="input-group tooltip">
                        <label for="contrasena">Contraseña</label>
                        <input type="password" id="contrasena" name="contrasena" required>
                    </div>
                    <div class="input-group tooltip">
                        <label for="confirmar_contrasena">Confirmar Contraseña</label>
                        <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" required>
                        <span class="tooltiptext">Confirma tu contraseña.</span>
                    </div>
                    <div class="input-group">
                        <label for="rol">Rol</label>
                        <select id="rol" name="rol" required onchange="toggleLaborField()">
                            <option value="">Seleccionar rol</option>
                            <option value="admin">Administrador</option>
                            <option value="usuario">Usuario</option>
                            <option value="trabajador">Trabajador</option>
                        </select>
                    </div>
                    <div class="input-group" id="labor-field" style="display: none;">
                        <label for="labor">Labor</label>
                        <input type="text" id="labor" name="labor">
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
