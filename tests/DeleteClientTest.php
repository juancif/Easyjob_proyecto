<?php
use PHPUnit\Framework\TestCase;

class DeleteClientTest extends TestCase
{
    protected $dbConn;

    protected function setUp(): void
    {
        // Crear una base de datos en memoria para las pruebas
        $this->dbConn = new PDO('sqlite::memory:');
        $this->dbConn->exec("
            CREATE TABLE cliente (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nombres TEXT,
                email TEXT,
                celular TEXT,
                contrasena TEXT
            )
        ");
        
        // Insertar datos de prueba
        $this->dbConn->exec("
            INSERT INTO cliente (nombres, email, celular, contrasena) 
            VALUES ('John Doe', 'john@example.com', '123456789', 'password123')
        ");
    }

    public function testDeleteClientSuccess()
    {
        // Simular la URL con el parámetro 'id'
        $_GET['id'] = 1;

        // Incluir el archivo PHP que contiene la lógica a probar
        ob_start();
        include 'delete_gestor.php';  // Asegúrate de que la ruta al archivo sea correcta
        $output = ob_get_clean();

        // Verificar que el usuario ha sido eliminado
        $query = $this->dbConn->prepare("SELECT * FROM cliente WHERE id = 1");
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);

        $this->assertFalse($user, "El usuario no fue eliminado correctamente.");

        // Verificar que el mensaje de éxito está presente en la salida
        $this->assertStringContainsString('Usuario eliminado correctamente', $output);
    }

    public function testDeleteClientNotFound()
    {
        // Simular la URL con un 'id' que no existe
        $_GET['id'] = 999;

        // Incluir el archivo PHP que contiene la lógica a probar
        ob_start();
        include 'delete_gestor.php';  // Asegúrate de que la ruta al archivo sea correcta
        $output = ob_get_clean();

        // Verificar que el mensaje de error está presente en la salida
        $this->assertStringContainsString('Usuario no encontrado', $output);
    }
}
