<?php
    
    $host = 'localhost';
    $bdname = 'UserIvancho';
    $username = 'Ivancho';
    $password = '1234';
    $puerto = '1433';

    try {
        // Definir la cadena de conexión
        $dsn = "sqlsrv:Server=$host,$puerto;Database=$bdname";
    
        // Crear la conexión PDO con el modo de excepción PDO habilitado
        $conn = new PDO($dsn, $username, $password, array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ));
    
        // Devolver la conexión
        return $conn;
    } catch (PDOException $exp) {
        // Lanzar una excepción personalizada en caso de error de conexión
        throw new Exception("No se pudo conectar a la base de datos: $bdname, error: " . $exp->getMessage());
    }
    ?>