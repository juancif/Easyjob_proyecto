<?php
include_once("config_gestor.php");

if (isset($_POST['Submit'])) {
    $nombres_apellidos = $_POST['nombres_apellidos'];
    $email = $_POST['email'];
    $celular = $_POST['celular'];
    $contrasena = $_POST['contrasena'];

    if (empty($nombres_apellidos) || empty($email) || empty($celular) || empty($contrasena)) {
        if (empty($nombres_apellidos)) echo "<font color='red'>Campo: nombres_apellidos está vacío.</font><br/>";
        if (empty($email)) echo "<font color='red'>Campo: email está vacío.</font><br/>";
        if (empty($celular)) echo "<font color='red'>Campo: celular está vacío.</font><br/>";
        if (empty($contrasena)) echo "<font color='red'>Campo: contraseña está vacío.</font><br/>";
        echo "<br/><a href='javascript:self.history.back();'>Volver</a>";
    } else {
        try {
            $dbConn->beginTransaction();
            $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT);
            $sql = "INSERT INTO administrador (nombres_apellidos, email, celular, contrasena) VALUES (:nombres_apellidos, :email, :celular, :contrasena)";
            $query = $dbConn->prepare($sql);
            $query->bindParam(':nombres_apellidos', $nombres_apellidos);
            $query->bindParam(':email', $email);
            $query->bindParam(':celular', $celular);
            $query->bindParam(':contrasena', $contrasena);
            $query->execute();
            $dbConn->commit();

            if ($query->rowCount() > 0) {
                header("Location: registro_exitoso_admin.php");
                exit();
            } else {
                echo "<font color='red'>Error al registrar el administrador.</font><br/>";
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
    <title>Registro de administradores</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Poppins:wght@400;600&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../css/style_add_gestor.css">
</head>
<body>
    <header class="header">
    </header>
    <main class="main-content">
        <div class="register-container">
            <div class="register-box">
                <h2>Registro de administradores</h2>
                <form method="post" action="">
                    <div class="input-group">
                        <label for="nombres_apellidos">Nombres y Apellidos</label>
                        <input type="text" id="nombres_apellidos" name="nombres_apellidos" required>
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
                        <input type="password" id="contrasena" name="contrasena" required >
                    </div>

                    <div class="buttons">
                        <input type="submit" name="Submit" value="Registrarse" class="Registrarse">
                        <a href="http://localhost/Easyjob_proyecto/Gestor_usuarios/php/admin/index_gestor_admin.php" class="regresar">Regresar</a>
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