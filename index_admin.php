<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrador</title>
    <link rel="stylesheet" href="index_admin.css">
</head>
<body>
    <div class="container">
        <!-- Barra superior -->
        <header>
            <div class="search-bar">
                <input type="text" placeholder="Buscar usuarios...">
                <button>Buscar</button>
            </div>
            <div class="user-options">
                <a href="logout.php">Cerrar Sesión</a>
            </div>
        </header>

        <!-- Menú lateral (sin opciones de destacados, mensajes, etc.) -->
        <nav class="sidebar">
            <ul>
                <li><a href="gestor_usuarios.php"><img src="icons/users.png" alt="Gestor de Usuarios"> Gestor de Usuarios</a></li>
                <li><a href="reportes.php"><img src="icons/reports.png" alt="Reportes"> Reportes</a></li>
                <li><a href="configuracion_admin.php"><img src="icons/settings.png" alt="Configuración"> Configuración</a></li>
            </ul>
        </nav>

        <!-- Contenido Principal -->
        <main>
            <section class="user-management">
                <h2>Gestor de Usuarios</h2>
                <div class="user-actions">
                    <button onclick="window.location.href='agregar_usuario.php'">Agregar Usuario</button>
                    <button onclick="window.location.href='eliminar_usuario.php'">Eliminar Usuario</button>
                </div>
                <div class="user-list">
                    <h3>Usuarios Registrados</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Aquí irán los usuarios cargados desde la base de datos -->
                            <tr>
                                <td>Juan Pérez</td>
                                <td>juan.perez@example.com</td>
                                <td>Cliente</td>
                                <td>
                                    <a href="editar_usuario.php?id=1">Editar</a> |
                                    <a href="eliminar_usuario.php?id=1">Eliminar</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Ana Gómez</td>
                                <td>ana.gomez@example.com</td>
                                <td>Trabajador</td>
                                <td>
                                    <a href="editar_usuario.php?id=2">Editar</a> |
                                    <a href="eliminar_usuario.php?id=2">Eliminar</a>
                                </td>
                            </tr>
                            <!-- Agregar más usuarios -->
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
