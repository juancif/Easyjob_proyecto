<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "easyjob";

$connect = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($connect->connect_error) {
    die("Error de conexión: " . $connect->connect_error);
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nombres_apellidos']) && isset($_POST['contrasena'])) {
        $nombres_apellidos = $_POST['nombres_apellidos'];
        $contrasena = $_POST['contrasena'];

        // Buscar en la tabla de usuario
        $stmt = $connect->prepare("SELECT * FROM usuario WHERE nombres_apellidos = ?");
        $stmt->bind_param("s", $nombres_apellidos);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();
            $hash_contrasena = $usuario['contrasena'];

            if (password_verify($contrasena, $hash_contrasena)) {
                $area = $usuario['area'];

                // Registrar el inicio de sesión en la tabla de movimientos
                $sql = "INSERT INTO movimientos (nombres_apellidos, accion, fecha) VALUES (?, 'Inicio de sesión', NOW())";
                $stmt = $connect->prepare($sql);
                $stmt->bind_param("s", $nombres_apellidos);
                $stmt->execute();

                // Guardar el área en la sesión
                $_SESSION['area'] = $area;
                $_SESSION['nombres_apellidos'] = $nombres_apellidos;

                // Redirigir al dashboard de usuario
                header("Location: http://localhost/Easyjob_proyecto/index_usuario.php");
                exit();
            } else {
                echo "Nombre de usuario o contraseña incorrectos.";
            }
        } else {
            // Verificar en la tabla de administradores
            $stmt = $connect->prepare("SELECT * FROM admin WHERE nombres_apellidos = ?");
            $stmt->bind_param("s", $nombres_apellidos);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $admin = $result->fetch_assoc();
                $hash_contrasena = $admin['contrasena'];

                if (password_verify($contrasena, $hash_contrasena)) {
                    $area = $admin['area'];

                    // Registrar el inicio de sesión en la tabla de movimientos
                    $sql = "INSERT INTO movimientos (nombres_apellidos, accion, fecha) VALUES (?, 'Inicio de sesión como administrador', NOW())";
                    $stmt = $connect->prepare($sql);
                    $stmt->bind_param("s", $nombres_apellidos);
                    $stmt->execute();

                    // Guardar el área en la sesión
                    $_SESSION['area'] = $area;
                    $_SESSION['nombres_apellidos'] = $nombres_apellidos;

                    // Redirigir al dashboard de administrador
                    header("Location: http://localhost/Easyjob_proyecto/index_admin.php");
                    exit();
                } else {
                    // Verificar en la tabla de trabajadores
                    $stmt = $connect->prepare("SELECT * FROM trabajador WHERE nombres_apellidos = ?");
                    $stmt->bind_param("s", $nombres_apellidos);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $trabajador = $result->fetch_assoc();
                        $hash_contrasena = $trabajador['contrasena'];

                        if (password_verify($contrasena, $hash_contrasena)) {
                            $area = $trabajador['area'];

                            // Registrar el inicio de sesión en la tabla de movimientos
                            $sql = "INSERT INTO movimientos (nombres_apellidos, accion, fecha) VALUES (?, 'Inicio de sesión como trabajador', NOW())";
                            $stmt = $connect->prepare($sql);
                            $stmt->bind_param("s", $nombres_apellidos);
                            $stmt->execute();

                            // Guardar el área en la sesión
                            $_SESSION['area'] = $area;
                            $_SESSION['nombres_apellidos'] = $nombres_apellidos;

                            // Redirigir al dashboard de trabajador
                            header("Location: http://localhost/Easyjob_proyecto/index_trabajador.php");
                            exit();
                        } else {
                            echo "Nombre de usuario o contraseña incorrectos.";
                        }
                    } else {
                        echo "Nombre de usuario o contraseña incorrectos.";
                    }
                }
            }
        }
    } else {
        echo "Por favor, ingrese nombre de usuario y contraseña.";
    }
}

// Cerrar la conexión
$connect->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicio Sesión</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Poppins:wght@400;600&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="login_easyjob.css">
</head>
<body>
    <header class="header">
    </header>
    <main class="main-content">
        <div class="login-container">
            <div class="login-box">
                <img src="../imagenes/user_verde.png" alt="User Icon" class="user-icon">
                <h2>BIENVENIDO</h2>
                <h2>A</h2>
                <h2>EASYJOB</h2>
                <form method="post" action="">
                    <div class="input-group">
                        <label for="nombres_apellidos">Nombres y apellidos</label>
                        <div class="input-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" id="nombres_apellidos" name="nombres_apellidos" required placeholder="Nombres y apellidos registrados">
                        </div>
                    </div>
                    <div class="input-group">
                        <label for="contrasena">Contraseña</label>
                        <div class="input-icon password-group">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="contrasena" name="contrasena" required placeholder="Contraseña" />
                        </div>
                    </div>
                    <div class="buttons">
                        <input type="submit" value="Ingresar">
                        <a href="http://localhost/Easyjob_proyecto/register/register_easyjob.php" class="button">Registrarse</a>
                        <a href="http://localhost/GateGourmet/restablecer/restablecer.php" class="button-reestablecer">Restablecer Contraseña</a> <!-- Botón pequeño y sutil -->
                    </div>
                </form>
            </div>
        </div>
    </main>
    <footer class="footer">
        <p><a href="#">Ayuda</a> | <a href="#">Términos de servicio</a></p>
    </footer>
    <script src="script2.js"></script>
</body>
</html>
