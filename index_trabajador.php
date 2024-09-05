<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Trabajador</title>
    <link rel="stylesheet" href="index_trabajador.css">
</head>
<body>
    <div class="container">
        <!-- Barra superior -->
        <header>
            <div class="search-bar">
                <input type="text" placeholder="Buscar mensajes o clientes...">
                <button>Buscar</button>
            </div>
            <div class="user-options">
                <!-- Si el trabajador está logueado -->
                <span>Bienvenido, [Nombre del Trabajador]</span>
                <a href="logout.php">Cerrar Sesión</a>
            </div>
        </header>

        <!-- Menú lateral -->
        <nav class="sidebar">
            <ul>
                <li><a href="perfil_trabajador.php"><img src="icons/user.png" alt="Perfil"> Perfil</a></li>
                <li><a href="mensajes_trabajador.php"><img src="icons/messages.png" alt="Mensajes"> Mensajes</a></li>
                <li><a href="configuracion_trabajador.php"><img src="icons/settings.png" alt="Configuración"> Configuración</a></li>
                <!-- Omitimos "Perfiles Destacados" -->
            </ul>
        </nav>

        <!-- Contenido Principal -->
        <main>
            <section class="dashboard-content">
                <h2>Resumen de Actividades</h2>
                <div class="dashboard-stats">
                    <div class="stat">
                        <h3>Servicios Prestados</h3>
                        <p>15</p>
                    </div>
                    <div class="stat">
                        <h3>Mensajes Nuevos</h3>
                        <p>3</p>
                    </div>
                    <div class="stat">
                        <h3>Calificación Promedio</h3>
                        <p>4.8/5</p>
                    </div>
                </div>

                <section class="update-profile">
                    <h2>Actualizar Perfil</h2>
                    <form action="actualizar_perfil.php" method="POST" enctype="multipart/form-data">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" value="[Nombre Actual]" required>

                        <label for="servicio">Servicio que presta:</label>
                        <input type="text" name="servicio" value="[Servicio Actual]" required>

                        <label for="experiencia">Años de experiencia:</label>
                        <input type="number" name="experiencia" value="[Experiencia Actual]" required>

                        <label for="celular">Celular:</label>
                        <input type="text" name="celular" value="[Celular Actual]" required>

                        <label for="descripcion">Descripción:</label>
                        <textarea name="descripcion" required>[Descripción Actual]</textarea>

                        <label for="foto">Foto de perfil:</label>
                        <input type="file" name="foto">

                        <button type="submit">Actualizar Perfil</button>
                    </form>
                </section>
            </section>
        </main>
    </div>
</body>
</html>
