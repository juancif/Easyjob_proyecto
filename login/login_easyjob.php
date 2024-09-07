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
    if (isset($_POST['id']) && isset($_POST['contrasena'])) {
        $id = $_POST['id'];
        $contrasena = $_POST['contrasena'];

        // Verificar en la tabla cliente
        $stmt = $connect->prepare("SELECT * FROM cliente WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $cliente = $result->fetch_assoc();
            $hash_contrasena = $cliente['contrasena'];

            if (password_verify($contrasena, $hash_contrasena)) {
                $_SESSION['id'] = $id;
                $_SESSION['user_type'] = 'cliente';
                $nombres = $cliente['nombres'];

                // Registrar el inicio de sesión en la tabla de movimientos
                $sql = "INSERT INTO movimientos (id, accion, fecha) VALUES (?, 'Inicio de sesión', NOW())";
                $stmt = $connect->prepare($sql);
                $stmt->bind_param("s", $id);
                $stmt->execute();

                // Redirigir al dashboard de cliente
                header("Location: http://localhost/Easyjob_proyecto/index_cliente.php");
                exit();
            } else {
                echo "Nombre de usuario o contraseña incorrectos.";
            }
        } else {
            // Verificar en la tabla trabajador
            $stmt = $connect->prepare("SELECT * FROM trabajador WHERE id = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $trabajador = $result->fetch_assoc();
                $hash_contrasena = $trabajador['contrasena'];

                if (password_verify($contrasena, $hash_contrasena)) {
                    $_SESSION['id'] = $id;
                    $_SESSION['user_type'] = 'trabajador';
                    $nombres = $trabajador['nombres'];

                    // Registrar el inicio de sesión en la tabla de movimientos
                    $sql = "INSERT INTO movimientos (id, accion, fecha) VALUES (?, 'Inicio de sesión', NOW())";
                    $stmt = $connect->prepare($sql);
                    $stmt->bind_param("s", $id);
                    $stmt->execute();

                    // Redirigir al dashboard de trabajador
                    header("Location: http://localhost/Easyjob_proyecto/index_trabajador.php");
                    exit();
                } else {
                    echo "Nombre de usuario o contraseña incorrectos.";
                }
            } else {
                // Verificar en la tabla administrador
                $stmt = $connect->prepare("SELECT * FROM administrador WHERE id = ?");
                $stmt->bind_param("s", $id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $administrador = $result->fetch_assoc();
                    $hash_contrasena = $administrador['contrasena'];

                    if (password_verify($contrasena, $hash_contrasena)) {
                        $_SESSION['id'] = $id;
                        $_SESSION['user_type'] = 'administrador';
                        $nombres = $administrador['nombres'];

                        // Registrar el inicio de sesión en la tabla de movimientos
                        $sql = "INSERT INTO movimientos (id, accion, fecha) VALUES (?, 'Inicio de sesión', NOW())";
                        $stmt = $connect->prepare($sql);
                        $stmt->bind_param("s", $id);
                        $stmt->execute();

                        // Redirigir al dashboard de administrador
                        header("Location: http://localhost/Easyjob_proyecto/index_administrador.php");
                        exit();
                    } else {
                        echo "Nombre de usuario o contraseña incorrectos.";
                    }
                } else {
                    echo "Nombre de usuario o contraseña incorrectos.";
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
                        <label for="id">Nombre de usuario</label>
                        <div class="input-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" id="id" name="id" required placeholder="Nombre de usuario" value="<?php if(isset($_POST['id'])) echo htmlspecialchars($_POST['id']); ?>"/>
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
