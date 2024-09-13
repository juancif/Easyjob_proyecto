<?php
include_once("config_gestor.php");

// Consulta a la base de datos
$result = $dbConn->query("SELECT * FROM administrador ORDER BY nombres_apellidos ASC");
?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de usuarios</title>
    <link rel="stylesheet" href="../../css/style_gestor.css">
</head>
<body>
<header class="header">
        <li class="nav__item__user">
                <a href="http://localhost/GateGourmet/Index/index_admin.html" class="cerrar__sesion__link"><img src="../../../Imagenes/regresar.png" alt="Usuario" class="img__usuario"><div class="cerrar__sesion">Volver al inicio</div></a>
            </li>
    </header>
    <a href="add_gestor_admin.php" class="botones boton_adicionar">Adicionar administrador</a>
    <a href="http://localhost/Easyjob_proyecto/Gestor_usuarios/php/trabajador/index_gestor_trabajador.php" class="botones boton_inactivos">Ver trabajadores</a>
    <a href="http://localhost/Easyjob_proyecto/Gestor_usuarios/php/user/index_gestor.php" class="botones boton_volver">Ver usuarios</a>
    <div>
    <table class="tabla_principal">
        <th class="cuadro_titulo">ADMINISTRADORES</th>
            <tr class="tabla_secundaria">
                <th>ID</th>
                <th>NOMBRES</th>
                <th>EMAIL</th>
                <th>CELULAR</th>
                <th>CONTRASEÑA</th>
             <th>EDICIÓN</th>
            </tr>
            <?php
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nombres_apellidos']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['celular']) . "</td>";
                echo "<td>" . htmlspecialchars($row['contrasena']) . "</td>";
                echo "<td class='acciones'>
                        <a href='edit_gestor_admin.php?id=" . htmlspecialchars($row['id']) . "'>Editar</a> | 
                        <a href='delete_gestor_admin.php?id=" . htmlspecialchars($row['id']) . "' 
                           onclick=\"return confirm('¿Está seguro de eliminar este registro?')\">Eliminar</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>    
    <footer class="footer">
        <p><a href="#">Ayuda</a> | <a href="#">Términos de servicio</a></p>
    </footer>
</body>
</html>