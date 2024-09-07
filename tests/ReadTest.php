<?php
use PHPUnit\Framework\TestCase;

class ReadTest extends TestCase
{
    protected $dbConn;

    protected function setUp(): void
    {
        // Configura la conexión a la base de datos
        $this->dbConn = new PDO('mysql:host=localhost;dbname=easyjob', 'root', '');
        $this->dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Asegúrate de que la base de datos está limpia antes de empezar
        $this->dbConn->exec("TRUNCATE TABLE cliente"); // Limpia la tabla cliente
        
        // Insertar datos de prueba
        $this->dbConn->exec("
            INSERT INTO cliente (nombres, email, celular, contrasena) 
            VALUES ('John Doe', 'john@example.com', '123456789', 'password123')
        ");
    }

    public function testHtmlGeneration()
    {
        // Captura la salida HTML
        ob_start();
        include '/Gestor_usuarios/php/user/index_gestor.php'; // Reemplaza con la ruta correcta
        $output = ob_get_clean();

        // Verificar la presencia de datos esperados en la salida HTML
        $this->assertStringContainsString('<td>1</td>', $output); // Asegúrate de que ID esté presente
        $this->assertStringContainsString('<td>John Doe</td>', $output); // Asegúrate de que nombres estén presentes
        $this->assertStringContainsString('<td>john@example.com</td>', $output); // Asegúrate de que email esté presente
        $this->assertStringContainsString('<td>123456789</td>', $output); // Asegúrate de que celular esté presente
        $this->assertStringContainsString('<td>password123</td>', $output); // Asegúrate de que contrasena esté presente
    }

    protected function tearDown(): void
    {
        // Limpiar después de cada prueba
        $this->dbConn = null;
    }
}
?>
