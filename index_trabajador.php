<?php
include_once("config_gestor.php");

// Consulta para obtener todos los trabajadores
$sql = "SELECT id, nombres_apellidos, celular, labor FROM trabajador WHERE rol = 'trabajador'";
$query = $dbConn->prepare($sql);
$query->execute();
$trabajadores = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easyjob</title>
    <link rel="stylesheet" href="index_trabajador.css">
</head>
<body>
    <nav class="nav__principal">
        <ul class="nav__list">
            <li class="nav__item">
                <a href="http://localhost/GateGourmet/listado_maestro/listado_maestro.php" class="nav__link"><img src="imagenes/ajustes.png" alt="Listado_maestro" class="imgs__menu">Ajustes</a>
            </li>
            <li class="nav__item">
                <a href="#" class="nav__link" id="serviciosLink"><img src="imagenes/servicios.png" alt="Crear datetime" class="imgs__menu">Servicios</a>
            </li>
            <li class="nav__item">
                <a href="#" class="nav__link" id="recomendadosLink"><img src="imagenes/usuarios.png" alt="Gestor_usuarios" class="imgs__menu">Recomendados</a>
            </li>
            <li class="nav__item">
                <!-- Enlace "Mensajes" que activará la ventana de chat -->
                <a href="#" class="nav__link" id="mensajesLink"><img src="imagenes/mensajes.png" alt="log_eventos" class="imgs__menu">Soporte</a>
            </li>
            <li class="nav__item nav__buscar">
                <input placeholder="Buscar servicio" class="nav__link nav__link__buscar">
                <img src="imagenes/lupa.png" alt="log_eventos" class="imgs__buscar">
            </li>
            <li class="nav__item__user">
                <a href="http://localhost/GateGourmet/Movimientos/logout.php" class="cerrar__sesion__link">
                    <img src="imagenes/user_verde.png" alt="Usuario" class="img__usuario">
                    <div class="cerrar__sesion">Cerrar Sesión</div>
                </a>
            </li>
        </ul>
    </nav>

    <div class="menu_lateral" id="menuLateral">
        <div class="recuadro_menu"></div>
        <div class="recuadro_menu"></div>
        <div class="recuadro_menu"></div>
        <div class="recuadro_menu"></div>
        <div class="recuadro_menu"></div>
        <div class="recuadro_menu"></div>
        <div class="recuadro_menu"></div>
        <div class="recuadro_menu"></div>
    </div>

    <!-- Ventana de chat -->
    <div class="chat_window" id="chatWindow">
        <div class="chat_header">
            <span>Chat</span>
            <button id="closeChat" class="close_chat">X</button>
        </div>
        <div class="chat_content">
            <!-- Contenido del chat (por ejemplo, mensajes) -->
            <p>Conéctate con nuestro soporte a través de WhatsApp o Facebook.</p>
            <a href="https://wa.me/3136474835" target="_blank">Abrir WhatsApp</a>
            <br>
            <a href="https://m.me/your-facebook-page" target="_blank">Abrir Messenger</a>
        </div>
    </div>

    <div class="noticias"></div>
    <div class="cuadros_perfiles">
    <?php 
    // Inicializa un contador para usar como clase dinámica
    $contador = 1; 

    // Itera sobre cada trabajador
    foreach ($trabajadores as $trabajador): ?>
        <!-- Hacemos que todo el cuadro sea un enlace -->
        <a href="trabajador.php?id=<?php echo htmlspecialchars($trabajador['id']); ?>" class="cuadro_perfil_link">
            <div class="cuadro_perfil cuadro_perfil<?php echo $contador; ?>">
                <h3><?php echo htmlspecialchars($trabajador['nombres_apellidos']); ?></h3>
                <p><strong>Celular:</strong> <?php echo htmlspecialchars($trabajador['celular']); ?></p>
                <p><strong>Labor:</strong> <?php echo htmlspecialchars($trabajador['labor']); ?></p>
            </div>
        </a>
        <?php 
        // Incrementa el contador para la siguiente iteración
        $contador++; 
        ?>
    <?php endforeach; ?>
</div>



    <!-- JavaScript para manejar los clics y mostrar/ocultar el menú -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var menuLateral = document.getElementById('menuLateral');
            var serviciosLink = document.getElementById('serviciosLink');
            var recomendadosLink = document.getElementById('recomendadosLink');
            var mensajesLink = document.getElementById('mensajesLink');
            var chatWindow = document.getElementById('chatWindow');
            var closeChat = document.getElementById('closeChat');

            // Función para alternar la visibilidad del menú
            function toggleMenu() {
                menuLateral.classList.toggle('active');
            }

            // Función para mostrar/ocultar la ventana de chat
            function toggleChat() {
                chatWindow.classList.toggle('visible');
            }

            // Eventos de clic en los enlaces "Servicios" y "Recomendados"
            serviciosLink.addEventListener('click', function(event) {
                event.preventDefault();
                toggleMenu();
            });

            recomendadosLink.addEventListener('click', function(event) {
                event.preventDefault();
                toggleMenu();
            });

            // Evento de clic en el enlace "Mensajes"
            mensajesLink.addEventListener('click', function(event) {
                event.preventDefault();
                toggleChat();
            });

            // Evento para cerrar el chat
            closeChat.addEventListener('click', function(event) {
                event.preventDefault();
                toggleChat();
            });

            // Evento de clic en cualquier lugar del documento para cerrar el menú
            document.addEventListener('click', function(event) {
                if (!menuLateral.contains(event.target) && event.target !== serviciosLink && event.target !== recomendadosLink) {
                    menuLateral.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>
