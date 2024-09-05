<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Cliente</title>
    <link rel="stylesheet" href="index_cliente.css">
</head>
<body>
    <div class="container">
        <!-- Barra superior -->
        <header>
            <div class="search-bar">
                <input type="text" placeholder="Buscar trabajadores o servicios...">
                <button>Buscar</button>
            </div>
            <div class="user-options">
                <a href="login.php">Iniciar Sesión</a>
                <a href="register.php">Registrarse</a>
            </div>
        </header>

        <!-- Menú lateral -->
        <nav class="sidebar">
            <ul>
                <li><a href="mensajes_cliente.php"><img src="icons/messages.png" alt="Mensajes"> Mensajes</a></li>
                <li><a href="configuracion_cliente.php"><img src="icons/settings.png" alt="Configuración"> Configuración</a></li>
                <li><a href="perfiles_destacados_cliente.php"><img src="icons/featured.png" alt="Perfiles Destacados"> Perfiles Destacados</a></li>
            </ul>
        </nav>

        <!-- Contenido Principal -->
        <main>
            <section class="worker-profiles">
                <h2>Trabajadores Disponibles</h2>
                <div class="profiles-container">
                    <div class="profile-card">
                        <img src="images/worker1.jpg" alt="Trabajador">
                        <h3>Juan Pérez</h3>
                        <p>Servicio: Plomería</p>
                        <p>Experiencia: 5 años</p>
                        <p>Contacto: 555-1234</p>
                    </div>
                    <div class="profile-card">
                        <img src="images/worker2.jpg" alt="Trabajador">
                        <h3>Ana Gómez</h3>
                        <p>Servicio: Electricidad</p>
                        <p>Experiencia: 7 años</p>
                        <p>Contacto: 555-5678</p>
                    </div>
                    <!-- Agrega más perfiles según sea necesario -->
                </div>
            </section>
        </main>
    </div>
</body>
</html>
