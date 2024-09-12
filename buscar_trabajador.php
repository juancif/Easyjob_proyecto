<?php
include_once("config_gestor.php");

// Obtener el término de búsqueda del parámetro GET
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

$sql = "SELECT id, nombres_apellidos, celular, labor FROM trabajador WHERE rol = 'trabajador' AND labor LIKE :busqueda";
$query = $dbConn->prepare($sql);
$query->execute(['busqueda' => '%' . $busqueda . '%']);
$trabajadores = $query->fetchAll(PDO::FETCH_ASSOC);

// Devolver los resultados como JSON
echo json_encode($trabajadores);
?>
