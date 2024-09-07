<?php
use PHPUnit\Framework\TestCase;

class EditGestorTest extends TestCase
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

    public function testUpdateClientSuccess()
    {
        // Simular los datos de $_POST
        $_POST['update'] = true;
        $_POST['id'] = 1;
        $_POST['nombres'] = 'Jane Doe';
        $_POST['email'] = 'jane@example.com';
        $_POST['celular'] = '987654321';
        $_POST['contrasena'] = 'newpassword';

        // Incluir el archivo PHP que contiene la lógica a probar
        include 'edit_gestor.php';

        // Verificar que los datos fueron actualizados en la base de datos
        $query = $this->dbConn->prepare("SELECT * FROM cliente WHERE id = 1");
        $query->execute();
        $updatedClient = $query->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals('Jane Doe', $updatedClient['nombres']);
        $this->assertEquals('jane@example.com', $updatedClient['email']);
        $this->assertEquals('987654321', $updatedClient['celular']);
        $this->assertEquals('newpassword', $updatedClient['contrasena']);
    }

    public function testValidationErrors()
    {
        // Simular un formulario con campos vacíos
        $_POST['update'] = true;
        $_POST['id'] = 1;
        $_POST['nombres'] = '';
        $_POST['email'] = '';
        $_POST['celular'] = '';
        $_POST['contrasena'] = '';

        // Capturar la salida
        ob_start();
        include 'edit_gestor.php';
        $output = ob_get_clean();

        // Verificar que los mensajes de error se muestran
        $this->assertStringContainsString('Campo: nombres está vacío.', $output);
        $this->assertStringContainsString('Campo: email está vacío.', $output);
        $this->assertStringContainsString('Campo: celular está vacío.', $output);
        $this->assertStringContainsString('Campo: contrasena está vacío.', $output);
    }
}
