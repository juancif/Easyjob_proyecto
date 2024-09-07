<?php
use PHPUnit\Framework\TestCase;

class RegisterTest extends TestCase
{
    protected $dbConn;

    protected function setUp(): void
    {
        // Configura la conexión a la base de datos
        $this->dbConn = new PDO('mysql:host=localhost;dbname=easyjob', 'root', '');
        $this->dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function testRegisterUser()
    {
        // Datos de prueba
        $nombres = 'Juan Pérez';
        $email = 'juan.perez@example.com';
        $celular = '1234567890';
        $contrasena = 'Password@123';

        // Preparar la solicitud POST
        $_POST['nombres'] = $nombres;
        $_POST['email'] = $email;
        $_POST['celular'] = $celular;
        $_POST['contrasena'] = $contrasena;

        // Incluye el archivo con el código PHP que se va a probar
        include_once('add_gestor.php'); // Asegúrate de que el archivo PHP esté en la ruta correcta

        // Verificar si el usuario ha sido registrado correctamente
        $query = $this->dbConn->prepare("SELECT * FROM cliente WHERE email = :email");
        $query->bindParam(':email', $email);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $this->assertNotEmpty($result, 'El usuario no fue registrado correctamente.');
        $this->assertEquals($nombres, $result['nombres']);
        $this->assertEquals($email, $result['email']);
        $this->assertEquals($celular, $result['celular']);
        $this->assertTrue(password_verify($contrasena, $result['contrasena']));
    }

    protected function tearDown(): void
    {
        // Limpiar después de cada prueba
        $this->dbConn = null;
    }
}
?>
