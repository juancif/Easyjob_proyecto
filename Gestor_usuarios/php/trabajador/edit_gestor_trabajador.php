<?php
include_once("config_gestor.php");

if (isset($_POST['update'])) {
    $id = $_POST['id']; // Asegúrate de obtener el ID
    $nombres = $_POST['nombres'];
    $email = $_POST['email'];
    $celular = $_POST['celular'];
    $contrasena = $_POST['contrasena'];

    // Validación de campos
    $errors = [];
    if (empty($nombres)) $errors[] = "Campo: nombres está vacío.";
    if (empty($email)) $errors[] = "Campo: email está vacío.";
    if (empty($celular)) $errors[] = "Campo: celular está vacío.";
    if (empty($contrasena)) $errors[] = "Campo: contrasena está vacío.";
    
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<font color='red'>{$error}</font><br/>";
        }
    } else {
        // Actualizar el usuario sin mover entre tablas
        $sql_update = "UPDATE usuario SET nombres=:nombres, email=:email, celular=:celular, contrasena=:contrasena
                       WHERE id=:id";
        $query_update = $dbConn->prepare($sql_update);
        $query_update->bindParam(':nombres', $nombres);
        $query_update->bindParam(':email', $email);
        $query_update->bindParam(':celular', $celular);
        $query_update->bindParam(':contrasena', $contrasena);
        $query_update->bindParam(':id', $id); // Vincula el ID
        $query_update->execute();

        // Redirigir a index_gestor.php después de la actualización
        header("Location: index_gestor.php");
        exit();
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM usuario WHERE id=:id";
    $query = $dbConn->prepare($sql);
    $query->execute([':id' => $id]);
    $row = $query->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $nombres = $row['nombres'];
        $email = $row['email'];
        $celular = $row['celular'];
        $contrasena = $row['contrasena'];
    } else {
        echo "Usuario no encontrado.";
        exit();
    }
}
?>

<html>
<head>
    <title>Editar Datos</title>
    <link rel="stylesheet" href="style_edit_gestor_user.css">
</head>
<body>
<form name="form1" method="post" action="edit_gestor.php">
    <header class="header">
    </header>
    <main class="main-content">
        <div class="register-container">
            <div class="register-box">
                <h2>Edición de usuario</h2>
                <form method="post" action="edit_gestor.php">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <div class="input-group">
                        <label for="nombres">Nombres y Apellidos</label>
                        <input type="text" id="nombres" name="nombres" required value="<?php echo htmlspecialchars($nombres, ENT_QUOTES); ?>">
                    </div>
                    <div class="input-group">
                        <label for="email">Correo electronico</label>
                        <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>">
                    </div>
                    <div class="input-group">
                        <label for="celular">Celular</label>
                        <input type="number" id="celular" name="celular" required value="<?php echo htmlspecialchars($celular, ENT_QUOTES); ?>">
                    </div>
                    <div class="input-group">
                        <label for="contrasena">Contraseña</label>
                        <input type="password" id="contrasena" name="contrasena" required value="<?php echo htmlspecialchars($contrasena, ENT_QUOTES); ?>">
                    </div>
                    <div class="buttons">
                        <input type="submit" name="update" value="Editar" class="Registrarse">
                        <a href="index_gestor.php" class="regresar">Volver</a>
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
