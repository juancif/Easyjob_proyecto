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
                <a href="http://localhost/GateGourmet/listado_maestro/listado_maestro.php" class="nav__link"><img src="imagenes/ajustes.png" alt="Listado_maestro" class="imgs__menu">Perfil</a>
            </li>
            <li class="nav__item">
                <a href="#" class="nav__link" id="serviciosLink"><img src="imagenes/servicios.png" alt="Crear datetime" class="imgs__menu">Servicios</a>
            </li>
            <li class="nav__item">
                <a href="http://localhost/Easyjob_proyecto/Gestor_usuarios/php/user/index_gestor.php" class="nav__link" ><img src="imagenes/usuarios.png" alt="Gestor_usuarios" class="imgs__menu">Gestor de usuarios</a>
            </li>
            <li class="nav__item">
                <!-- Enlace "Mensajes" que activará la ventana de chat -->
                <a href="#" class="nav__link" id="mensajesLink"><img src="imagenes/mensajes.png" alt="log_eventos" class="imgs__menu">Mensajes</a>
            </li>
            <li class="nav__item nav__buscar">
                <input id="buscarServicio" placeholder="Buscar servicio" class="nav__link nav__link__buscar">
                <img src="imagenes/lupa.png" alt="Buscar" class="imgs__buscar">
            </li>
            <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Selección de elementos del DOM
        const buscarServicio = document.getElementById('buscarServicio');
        const cuadrosPerfiles = document.querySelector('.cuadros_perfiles');

        // Evento de entrada en el campo de búsqueda
        buscarServicio.addEventListener('input', function() {
            const query = buscarServicio.value;

            // Realizar la solicitud AJAX al script PHP
            fetch('buscar_trabajador.php?busqueda=' + encodeURIComponent(query))
                .then(response => response.json())
                .then(data => {
                    // Limpiar los resultados anteriores
                    cuadrosPerfiles.innerHTML = '';

                    // Mostrar los resultados nuevos
                    data.forEach(trabajador => {
                        const trabajadorHTML = `
                            <a href="trabajador.php?id=${trabajador.id}" class="cuadro_perfil_link">
                                <div class="cuadro_perfil">
                                    <div class="foto_perfil">Foto</div>
                                    <h3>${trabajador.nombres_apellidos}</h3>
                                    <p><strong>Celular:</strong> ${trabajador.celular}</p>
                                    <p><strong>Labor:</strong> ${trabajador.labor}</p>
                                </div>
                            </a>
                        `;
                        cuadrosPerfiles.insertAdjacentHTML('beforeend', trabajadorHTML);
                    });
                })
                .catch(error => console.error('Error al realizar la solicitud:', error));
        });
    });
</script>
            <li class="nav__item__user">
                <a href="http://localhost/GateGourmet/Movimientos/logout.php" class="cerrar__sesion__link">
                    <img src="imagenes/user_verde.png" alt="Usuario" class="img__usuario">
                    <div class="cerrar__sesion">Cerrar Sesión</div>
                </a>
            </li>
        </ul>
    </nav>

    <div class="menu_lateral" id="menuLateral">
        <div class="recuadro_menu"><a href="" class="link_servicios">Plomeria</a></div>
        <div class="recuadro_menu"><a href="" class="link_servicios">Cerrajeria</a></div>
        <div class="recuadro_menu"><a href="" class="link_servicios">Soldadura</a></div>
        <div class="recuadro_menu"><a href="" class="link_servicios">Pintura</a></div>
        <div class="recuadro_menu"><a href="" class="link_servicios">Electricista</a></div>
        <div class="recuadro_menu recuadro_menu2"><a href="" class="link_servicios2">Arreglos generales</a></div>
        <div class="recuadro_menu recuadro_menu3"><a href="" class="link_servicios3">Arreglos electrodomesticos</a></div>
        <div class="recuadro_menu"><a href="" class="link_servicios">Otros...</a></div>
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

    <div class="noticias">
        <div class="carousel" id="carousel">
            <img src="imagenes/img_recuadro4.jpg" alt="Noticia 1">
            <img src="imagenes/img_recuadro2.jpg" alt="Noticia 1">
            <img src="imagenes/img_recuadro5.jpg" alt="Noticia 1">
            <img src="imagenes/img_recuadro.jpeg" alt="Noticia 2">
            <img src="imagenes/img_recuadro3.avif" alt="Noticia 3">
        </div>
        <button class="arrow left-arrow" onclick="prevImage()">&#8249;</button>
        <button class="arrow right-arrow" onclick="nextImage()">&#8250;</button>
    </div>

    <script>
        let currentIndex = 0;
        const images = document.querySelectorAll('#carousel img');
        const totalImages = images.length;

        function showImage(index) {
            document.getElementById('carousel').style.transform = `translateX(-${index * (100 / totalImages)}%)`;
        }

        function nextImage() {
            currentIndex = (currentIndex + 1) % totalImages;
            showImage(currentIndex);
        }

        function prevImage() {
            currentIndex = (currentIndex - 1 + totalImages) % totalImages;
            showImage(currentIndex);
        }

        setInterval(nextImage, 4000); // Cambia de imagen cada 3 segundos
    </script>
    <div class="cuadros_perfiles">
    <?php 
    $contador = 1; 
    foreach ($trabajadores as $trabajador): ?>
        <a href="trabajador.php?id=<?php echo htmlspecialchars($trabajador['id']); ?>" class="cuadro_perfil_link">
            <div class="cuadro_perfil <?php echo $contador; ?>">
                <!-- Recuadro para la foto de perfil -->
                <div class="foto_perfil">
                    Foto
                </div>
                <h3><?php echo htmlspecialchars($trabajador['nombres_apellidos']); ?></h3>
                <p><strong>Celular:</strong> <?php echo htmlspecialchars($trabajador['celular']); ?></p>
                <p><strong>Labor:</strong> <?php echo htmlspecialchars($trabajador['labor']); ?></p>
            </div>
        </a>
        <?php $contador++; ?>
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
