<?php
use PHPUnit\Framework\TestCase;

class RegistroTest extends TestCase
{
    protected $dbConn;

    protected function setUp(): void
    {
        // Configura la conexión a la base de datos
        $this->dbConn = new PDO('mysql:host=localhost;dbname=easyjob', 'root', '');
        $this->dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Asegúrate de que la base de datos está limpia antes de empezar
        $this->dbConn->exec("TRUNCATE TABLE usuario"); // Limpia la tabla usuario
    }

    public function testRegisterUser()
    {
        // Datos de prueba
        $nombres_apellidos = "jose";
        $email = "jose@example.com";
        $celular = "12345673123";
        $contrasena = "Password@122";

        // Simular el código PHP en lugar de usar $_POST
        // Refactoriza add_gestor.php para aceptar parámetros en lugar de usar $_POST
        $this->registerUser($nombres_apellidos, $email, $celular, $contrasena);

        // Verificar si el usuario ha sido registrado correctamente
        $query = $this->dbConn->prepare("SELECT * FROM usuario WHERE email = :email");
        $query->bindParam(':email', $email);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $this->assertNotEmpty($result, 'El usuario no fue registrado correctamente.');
        $this->assertEquals($nombres_apellidos, $result['nombres_apellidos']);
        $this->assertEquals($email, $result['email']);
        $this->assertEquals($celular, $result['celular']);
        $this->assertEquals($contrasena, $result['contrasena']);
    }

    protected function registerUser($nombres_apellidos, $email, $celular, $contrasena)
    {
        // Simula el proceso de registro en lugar de usar $_POST
        $stmt = $this->dbConn->prepare("INSERT INTO usuario (nombres_apellidos, email, celular, contrasena) VALUES (:nombres_apellidos, :email, :celular, :contrasena)");
        $stmt->bindParam(':nombres_apellidos', $nombres_apellidos);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':celular', $celular);
        $stmt->bindParam(':contrasena', $contrasena);
        $stmt->execute();
    }

    protected function tearDown(): void
    {
        // Limpiar después de cada prueba
        $this->dbConn = null;
    }
}
?>