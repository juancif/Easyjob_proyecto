<?php
include_once("config_gestor.php");

if (isset($_POST['Submit'])) {
    $nombres = $_POST['nombres'];
    $email = $_POST['email'];
    $celular = $_POST['celular'];
    $contrasena = $_POST['contrasena'];
    // Verificar si algún campo está vacío
    if (empty($nombres) ||  empty($email) || empty($celular) || empty($contrasena)) {
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
            echo "<font color='red'>Campo: contrasena está vacío.</font><br/>";
        }
        echo "<br/><a href='javascript:self.history.back();'>Volver</a>";
    } else {
        try {
            // Iniciar la transacción
            $dbConn->beginTransaction();
        
            // Verificar si el id ya existe en la base de datos
            $checkDocSql = "SELECT COUNT(*) FROM cliente WHERE id = :id";
            $checkDocQuery = $dbConn->prepare($checkDocSql);
            $checkDocQuery->bindparam(':id', $id);
            $checkDocQuery->execute();
            $count = $checkDocQuery->fetchColumn();
        
            // Verificar el campo cargo y definir la tabla correspondiente
        {
                $sql = "INSERT INTO cliente (nombres, email,celular, contrasena) 
                        VALUES (:nombres, :email, :celular, :contrasena)";
            } 
        
            $query = $dbConn->prepare($sql);
            $query->bindparam(':nombres', $nombres);
            $query->bindparam(':email', $email);
            $query->bindparam(':celular', $celular);
            $query->bindparam(':contrasena', $contrasena); // Hash de la contraseña
            $query->execute();
        


            if ($query->rowCount() > 0) {
                // Redirigir a la página deseada después del registro exitoso
                header("Location: registro_exitoso.php");
                exit();
            } else {
                echo "<font color='red'>Error al registrar el usuario o administrador.</font><br/>";
            }
        } catch (Exception $e) {
            // Revertir los cambios si ocurre un error
            if ($dbConn->inTransaction()) {
                $dbConn->rollBack();
            }
            echo "<font color='red', font-size='30'>Error: " . $e->getMessage() . "</font><br/>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de trabajadores</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Poppins:wght@400;600&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="style_add_gestor.css">
</head>
<body>
    <header class="header">
    </header>
    <main class="main-content">
        <div class="register-container">
            <div class="register-box">
                <h2>Registro de trabajadores</h2>
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
                        <input type="password" id="contrasena" name="contrasena" required >
                        <span class="tooltiptext">Recuerda que la contraseña debe tener minimo 12 caracteres, un caracter especial y una mayuscula.</span>
                    </div>

                    <div class="buttons">
                        <input type="submit" name="Submit" value="Registrarse" class="Registrarse">
                        <a href="http://localhost/GateGourmet/Gestor_trabajadores/php/user/index_gestor.php" class="regresar">Regresar</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <footer class="footer">
        <p><a href="#">Ayuda</a> | <a href="#">Términos de servicio</a></p>
        <script>
            document.querySelector('form').addEventListener('submit', function(event) {
                var emailField = document.getElementById('id');
                var emailValue = emailField.value;

                // Verificar si el id electrónico tiene el dominio específico
                if (!emailValue.endsWith('@gategroup.com')) {
                    alert('El id electrónico debe tener el dominio "@gategroup.com".');
                    event.preventDefault(); // Evita el envío del formulario
                }
            });
        </script>
        <script src="/script_prueba/script.js"></script>
    </footer>
</body>
</html>