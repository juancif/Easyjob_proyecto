<?php
use PHPUnit\Framework\TestCase;

class ActualizarUsuarioTest extends TestCase
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

    public function testUpdateUser()
    {
        // Datos iniciales del usuario
        $nombres_apellidos = "Jose Perez";
        $email = "jose.perez@example.com";
        $celular = "3194391427";
        $contrasena = "password123";

        // Primero registramos el usuario
        $this->registerUser($nombres_apellidos, $email, $celular, $contrasena);

        // Obtenemos el ID del usuario recién registrado
        $query = $this->dbConn->prepare("SELECT id FROM usuario WHERE email = :email");
        $query->bindParam(':email', $email);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);

        $this->assertNotEmpty($user, 'No se pudo encontrar al usuario después del registro.');

        $id = $user['id'];

        // Nuevos datos para la actualización
        $new_nombres_apellidos = "Juan Perez";
        $new_email = "juan.perez@example.com";
        $new_celular = "3245178844";
        $new_contrasena = "newpassword456";

        // Ejecutamos la actualización
        $this->updateUser($id, $new_nombres_apellidos, $new_email, $new_celular, $new_contrasena);

        // Verificar si el usuario ha sido actualizado correctamente
        $query = $this->dbConn->prepare("SELECT * FROM usuario WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        $updatedUser = $query->fetch(PDO::FETCH_ASSOC);

        $this->assertNotEmpty($updatedUser, 'No se encontró el usuario después de la actualización.');
        $this->assertEquals($new_nombres_apellidos, $updatedUser['nombres_apellidos']);
        $this->assertEquals($new_email, $updatedUser['email']);
        $this->assertEquals($new_celular, $updatedUser['celular']);
        $this->assertEquals($new_contrasena, $updatedUser['contrasena']);
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

    protected function updateUser($id, $nombres_apellidos, $email, $celular, $contrasena)
    {
        // Simula el proceso de actualización de usuario
        $stmt = $this->dbConn->prepare("UPDATE usuario SET nombres_apellidos = :nombres_apellidos, email = :email, celular = :celular, contrasena = :contrasena WHERE id = :id");
        $stmt->bindParam(':nombres_apellidos', $nombres_apellidos);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':celular', $celular);
        $stmt->bindParam(':contrasena', $contrasena);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    protected function tearDown(): void
    {
        // Limpiar después de cada prueba
        $this->dbConn = null;
    }
}
