<?php
include_once("config_gestor.php");

// Consulta a la base de datos
$result = $dbConn->query("SELECT * FROM trabajador ORDER BY id ASC");
?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de trabajadors</title>
    <link rel="stylesheet" href="../../css/style_gestor.css">
</head>
<body>
<header class="header">
        <li class="nav__item__user">
                <a href="http://localhost/Easyjob_proyecto/index_admin.php" class="cerrar__sesion__link"><img src="../../../Imagenes/regresar.png" alt="Usuario" class="img__usuario"><div class="cerrar__sesion">Volver al inicio</div></a>
            </li>
    </header>
    <a href="add_gestor_trabajador.php" class="botones boton_adicionar">Adicionar trabajador</a>
    <a href="http://localhost/Easyjob_proyecto/Gestor_usuarios/php/user/index_gestor.php" class="botones boton_inactivos">Ver usaurios</a>
    <a href="http://localhost/Easyjob_proyecto/Gestor_usuarios/php/admin/index_gestor_admin.php" class="botones boton_volver">Ver administradores</a>
        <table class="tabla_principal">
        <th class="cuadro_titulo">trabajadores</th>
            <tr class="tabla_secundaria">
                <th>ID</th>
                <th>NOMBRES</th>
                <th>EMAIL</th>
                <th>CELULAR</th>
                <th>CONTRASEÑA</th>
                <th>LABOR</th>
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
                echo "<td>" . htmlspecialchars($row['labor']) . "</td>";
                echo "<td class='acciones'>
                        <a href='edit_gestor_trabajador.php?id=" . htmlspecialchars($row['id']) . "'>Editar</a> | 
                        <a href='delete_gestor_trabajador.php?id=" . htmlspecialchars($row['id']) . "' 
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
