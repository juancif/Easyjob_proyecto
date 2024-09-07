<?php
include_once("config_gestor.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Iniciar transacción
        $dbConn->beginTransaction();

        // Obtener datos del usuario a eliminar
        $sqlSelect = "SELECT * FROM cliente WHERE id = :id";
        $stmtSelect = $dbConn->prepare($sqlSelect);
        $stmtSelect->bindParam(':id', $id);
        $stmtSelect->execute();
        $user = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Eliminar de la tabla administradores
            $sqlDelete = "DELETE FROM cliente WHERE id = :id";
            $stmtDelete = $dbConn->prepare($sqlDelete);
            $stmtDelete->bindParam(':id', $id);
            $stmtDelete->execute();

            // Cometer transacción
            $dbConn->commit();

            // Redirigir o mostrar un mensaje de éxito
            header("Location: http://localhost/GateGourmet/Gestor_usuarios/User/delete_gestor.php/?msg=Usuario eliminado correctamente");
            exit();
        } else {
            throw new Exception("Usuario no encontrado");
        }
    } catch (Exception $e) {
        // Revertir transacción en caso de error
        if ($dbConn->inTransaction()) {
            $dbConn->rollBack();
        }
        echo "<font color='red'>Error: " . $e->getMessage() . "</font><br/>";
    }
} else {
    echo "<font color='red'>No se ha especificado el nombre de usuario.</font><br/>";
}
?>
