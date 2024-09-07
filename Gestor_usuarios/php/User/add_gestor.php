<?php
include_once("config_gestor.php");

if (isset($_POST['Submit'])) {
    $nombres = $_POST['nombres'];
    $email = $_POST['email'];
    $celular = $_POST['celular'];
    $contrasena = $_POST['contrasena'];

    if (empty($nombres) || empty($email) || empty($celular) || empty($contrasena)) {
        if (empty($nombres)) echo "<font color='red'>Campo: nombres está vacío.</font><br/>";
        if (empty($email)) echo "<font color='red'>Campo: email está vacío.</font><br/>";
        if (empty($celular)) echo "<font color='red'>Campo: celular está vacío.</font><br/>";
        if (empty($contrasena)) echo "<font color='red'>Campo: contraseña está vacío.</font><br/>";
        echo "<br/><a href='javascript:self.history.back();'>Volver</a>";
    } else {
        try {
            $dbConn->beginTransaction();
            $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT);
            $sql = "INSERT INTO cliente (nombres, email, celular, contrasena) VALUES (:nombres, :email, :celular, :contrasena)";
            $query = $dbConn->prepare($sql);
            $query->bindParam(':nombres', $nombres);
            $query->bindParam(':email', $email);
            $query->bindParam(':celular', $celular);
            $query->bindParam(':contrasena', $contrasenaHash);
            $query->execute();
            $dbConn->commit();

            if ($query->rowCount() > 0) {
                header("Location: registro_exitoso.php");
                exit();
            } else {
                echo "<font color='red'>Error al registrar el usuario.</font><br/>";
            }
        } catch (Exception $e) {
            if ($dbConn->inTransaction()) $dbConn->rollBack();
            echo "<font color='red'>Error: " . $e->getMessage() . "</font><br/>";
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
                        <input type="text" id="email" name="email" required>
                    </div>
                    <div class="input-group">
                        <label for="celular">Celular</label>
                        <input type="number" id="celular" name="celular" required>
                    </div>
                    <div class="input-group tooltip">
                        <label for="contrasena">Contraseña</label>
                        <input type="text" id="contrasena" name="contrasena" required >
                    </div>

                    <div class="buttons">
                        <input type="submit" name="Submit" value="Registrarse" class="Registrarse">
                        <a href="http://localhost/Easyjob_proyecto/Gestor_usuarios/php/user/index_gestor.php" class="regresar">Regresar</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <footer class="footer">
        <p><a href="#">Ayuda</a> | <a href="#">Términos de servicio</a></p>
        <script src="/script_prueba/script.js"></script>
    </footer>
</body>
</html>