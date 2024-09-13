<?php
include_once("config_gestor.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Iniciar transacción
        $dbConn->beginTransaction();

        // Obtener datos del trabajador a eliminar
        $sqlSelect = "SELECT * FROM trabajador WHERE id = :id";
        $stmtSelect = $dbConn->prepare($sqlSelect);
        $stmtSelect->bindParam(':id', $id);
        $stmtSelect->execute();
        $user = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Eliminar de la tabla trabajador
            $sqlDelete = "DELETE FROM trabajador WHERE id = :id";
            $stmtDelete = $dbConn->prepare($sqlDelete);
            $stmtDelete->bindParam(':id', $id);
            $stmtDelete->execute();

            // Cometer transacción
            $dbConn->commit();

            // Mostrar mensaje de éxito sin redirección
            header("Location: index_gestor_trabajador.php?msg=trabajador eliminado correctamente");
        } else {
            throw new Exception("trabajador no encontrado");
        }
    } catch (Exception $e) {
        // Revertir transacción en caso de error
        if ($dbConn->inTransaction()) {
            $dbConn->rollBack();
        }
        echo "<font color='red'>Error: " . $e->getMessage() . "</font><br/>";
    }
} else {
    echo "<font color='red'>No se ha especificado el nombre de trabajador.</font><br/>";
}
?>
