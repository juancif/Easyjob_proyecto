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
        $stmtSelect->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtSelect->execute();
        $user = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Eliminar de la tabla cliente
            $sqlDelete = "DELETE FROM cliente WHERE id = :id";
            $stmtDelete = $dbConn->prepare($sqlDelete);
            $stmtDelete->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtDelete->execute();

            // Cometer transacción
            $dbConn->commit();

            // Mostrar mensaje de éxito sin redirección
            // En un entorno real, redirige a una página de éxito o muestra un mensaje de éxito
            header("Location: index_gestor.php?msg=Usuario eliminado correctamente");
            exit();  // Asegúrate de detener la ejecución después de la redirección
        } else {
            throw new Exception("Usuario no encontrado");
        }
    } catch (Exception $e) {
        // Revertir transacción en caso de error
        if ($dbConn->inTransaction()) {
            $dbConn->rollBack();
        }
        // Mostrar mensaje de error
        echo "<font color='red'>Error: " . $e->getMessage() . "</font><br/>";
    }
} else {
    // Mostrar mensaje si no se ha especificado el id
    echo "<font color='red'>No se ha especificado el id del usuario.</font><br/>";
}
?>
