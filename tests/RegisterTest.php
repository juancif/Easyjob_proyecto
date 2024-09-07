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
        
        // Asegúrate de que la base de datos está limpia antes de empezar
        $this->dbConn->exec("TRUNCATE TABLE cliente"); // Limpia la tabla cliente
    }

    public function testRegisterUser()
    {
        // Datos de prueba
        $nombres = 'jose';
        $email = 'jose@example.com';
        $celular = '12345673123';
        $contrasena = 'Password@122';

        // Simular el código PHP en lugar de usar $_POST
        // Refactoriza add_gestor.php para aceptar parámetros en lugar de usar $_POST
        $this->registerUser($nombres, $email, $celular, $contrasena);

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

    protected function registerUser($nombres, $email, $celular, $contrasena)
    {
        // Simula el proceso de registro en lugar de usar $_POST
        $stmt = $this->dbConn->prepare("INSERT INTO cliente (nombres, email, celular, contrasena) VALUES (:nombres, :email, :celular, :contrasena)");
        $stmt->bindParam(':nombres', $nombres);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':celular', $celular);
        $stmt->bindParam(':contrasena', password_hash($contrasena, PASSWORD_DEFAULT));
        $stmt->execute();
    }

    protected function tearDown(): void
    {
        // Limpiar después de cada prueba
        $this->dbConn = null;
    }
}
?>
