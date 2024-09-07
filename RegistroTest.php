<?php
use PHPUnit\Framework\TestCase;

class RegistroTest extends TestCase
{
    private $dbConn;

    protected function setUp(): void
    {
        // Configuración de la base de datos en memoria para pruebas
        $this->dbConn = new PDO('sqlite::memory:');
        $this->dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Crear la tabla 'cliente'
        $this->dbConn->exec("CREATE TABLE cliente (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nombres TEXT NOT NULL,
            email EMAIL NOT NULL,
            celular NUMBER NOT NULL,
            contrasena TEXT NOT NULL
        )");
    }

    public function testCampoVacio()
    {
        $_POST['Submit'] = true;
        $_POST['nombres'] = '';
        $_POST['email'] = '';
        $_POST['celular'] = '';
        $_POST['contrasena'] = '';

        ob_start();
        include 'Gestor_usuarios/php/user/add_gestor.php'; // Cambia esto a la ruta del archivo PHP
        $output = ob_get_clean();

        // Debug: imprime la salida para ver qué se está generando
        file_put_contents('debug_output.txt', $output);

        $this->assertStringContainsString('Campo: nombres está vacío.', $output);
        $this->assertStringContainsString('Campo: email está vacío.', $output);
        $this->assertStringContainsString('Campo: celular está vacío.', $output);
        $this->assertStringContainsString('Campo: contraseña está vacío.', $output);
    }

    public function testRegistroExitoso()
    {
        $_POST['Submit'] = true;
        $_POST['nombres'] = 'Juan Pérez';
        $_POST['email'] = 'juan@example.com';
        $_POST['celular'] = '123456789';
        $_POST['contrasena'] = 'ContraseñaSegura123!';

        ob_start();
        include 'Gestor_usuarios/php/user/add_gestor.php'; // Cambia esto a la ruta del archivo PHP
        $output = ob_get_clean();

        $this->assertStringNotContainsString('Error al registrar el usuario.', $output);
        $this->assertStringNotContainsString('Error: ', $output);

        $stmt = $this->dbConn->query("SELECT * FROM cliente WHERE email = 'juan@example.com'");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotEmpty($row, 'No se encontró el registro en la base de datos');
        $this->assertEquals('Juan Pérez', $row['nombres']);
        $this->assertEquals('juan@example.com', $row['email']);
        $this->assertEquals('123456789', $row['celular']);
        $this->assertNotEmpty($row['contrasena']);
        $this->assertTrue(password_verify('ContraseñaSegura123!', $row['contrasena']), 'La contraseña hasheada no coincide');
    }

    protected function tearDown(): void
    {
        $this->dbConn = null;
    }
}
