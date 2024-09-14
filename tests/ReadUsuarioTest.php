<?php

use PHPUnit\Framework\TestCase;

class ReadUsuarioTest extends TestCase
{
    // Método para simular la consulta de la base de datos
    public function testConsultaUsuarios()
    {
        // Mock de PDOStatement
        $pdoStatementMock = $this->createMock(PDOStatement::class);

        // Simula los resultados de la consulta
        $pdoStatementMock->expects($this->any())
                         ->method('fetch')
                         ->willReturnOnConsecutiveCalls(
                             ['id' => 12, 'nombres_apellidos' => 'Juan Pérez', 'email' => 'juan@mail.com', 'celular' => 123456789, 'contrasena' => 'hashed_password'],
                             ['id' => 2, 'nombres_apellidos' => 'Ana Gómez', 'email' => 'ana@mail.com', 'celular' => 987654321, 'contrasena' => 'hashed_password2'],
                             false
                         );

        // Mock de PDO para simular la conexión a la base de datos
        $pdoMock = $this->createMock(PDO::class);

        // Simula que al hacer query, devuelva el PDOStatement mockeado
        $pdoMock->expects($this->once())
                ->method('query')
                ->with('SELECT * FROM usuario ORDER BY id ASC')
                ->willReturn($pdoStatementMock);

        // Incluimos el archivo que tiene el código de la consulta
        // En este caso, config_gestor.php debe usar la variable $pdoMock
        include_once("config_gestor.php");

        // Realizamos las comprobaciones necesarias
        $result = $pdoMock->query("SELECT * FROM usuario ORDER BY id ASC");

        // Verificamos que el resultado sea un objeto PDOStatement
        $this->assertInstanceOf(PDOStatement::class, $result);

        // Verificamos que el primer registro es Juan Pérez
        $firstUser = $result->fetch(PDO::FETCH_ASSOC);
        $this->assertEquals('Juan Pérez', $firstUser['nombres_apellidos']);

        // Verificamos que el segundo registro es Ana Gómez
        $secondUser = $result->fetch(PDO::FETCH_ASSOC);
        $this->assertEquals('Ana Gómez', $secondUser['nombres_apellidos']);

        // Verificamos que no haya más registros
        $noMoreUsers = $result->fetch(PDO::FETCH_ASSOC);
        $this->assertFalse($noMoreUsers);
    }
}
