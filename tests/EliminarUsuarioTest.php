<?php

use PHPUnit\Framework\TestCase;

class EliminarUsuarioTest extends TestCase
{
    protected $dbConn;

    protected function setUp(): void
    {
        // Configura la conexión a la base de datos
        $this->dbConn = new PDO('mysql:host=localhost;dbname=easyjob', 'root', '');
        $this->dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Asegúrate de que la base de datos está limpia antes de empezar
        $this->dbConn->exec("TRUNCATE TABLE usuario"); // Limpia la tabla usuario

        // Inserta un usuario de prueba
        $this->dbConn->exec("INSERT INTO usuario (nombres_apellidos, email, celular, contrasena) VALUES ('jose', 'jose@example.com', '12345673123', '" . password_hash('password123', PASSWORD_BCRYPT) . "')");
    }

    public function testEliminarUsuario()
    {
        // Obtén el ID del usuario insertado
        $query = $this->dbConn->query("SELECT id FROM usuario WHERE email = 'jose@example.com'");
        $user = $query->fetch(PDO::FETCH_ASSOC);
        $id = $user['id'];

        // Simular la solicitud de eliminación
        $this->eliminarUsuario($id);

        // Verificar si el usuario ha sido eliminado
        $query = $this->dbConn->prepare("SELECT * FROM usuario WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $this->assertEmpty($result, 'El usuario no fue eliminado correctamente.');
    }

    protected function eliminarUsuario($id)
    {
        // Simula el proceso de eliminación en lugar de usar $_GET
        $this->dbConn->beginTransaction();
        try {
            // Obtener datos del usuario a eliminar
            $sqlSelect = "SELECT * FROM usuario WHERE id = :id";
            $stmtSelect = $this->dbConn->prepare($sqlSelect);
            $stmtSelect->bindParam(':id', $id);
            $stmtSelect->execute();
            $user = $stmtSelect->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Eliminar de la tabla usuario
                $sqlDelete = "DELETE FROM usuario WHERE id = :id";
                $stmtDelete = $this->dbConn->prepare($sqlDelete);
                $stmtDelete->bindParam(':id', $id);
                $stmtDelete->execute();

                // Cometer transacción
                $this->dbConn->commit();
            } else {
                throw new Exception("Usuario no encontrado");
            }
        } catch (Exception $e) {
            if ($this->dbConn->inTransaction()) {
                $this->dbConn->rollBack();
            }
            throw $e;
        }
    }

    protected function tearDown(): void
    {
        // Limpiar después de cada prueba
        $this->dbConn = null;
    }
}

?>
