<?php
// Guarda esto como test-sqlserver.php y ejecútalo con: php test-sqlserver.php

try {
    // Información de conexión
    $serverName = "127.0.0.1";
    $connectionOptions = [
        "Database" => "SIGA_1030",
        "Uid" => "sa",
        "PWD" => "954040025",
        "TrustServerCertificate" => true,
        "Encrypt" => false
    ];

    // Intenta conectar
    $conn = new PDO(
        "sqlsrv:Server=$serverName;Database={$connectionOptions['Database']}",
        $connectionOptions["Uid"],
        $connectionOptions["PWD"],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::SQLSRV_ATTR_ENCODING => PDO::SQLSRV_ENCODING_UTF8
        ]
    );

    echo "¡Conexión exitosa a SQL Server!\n";

    // Intenta hacer una consulta simple
    $stmt = $conn->query("SELECT TOP 1 * FROM INFORMATION_SCHEMA.TABLES");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "Primera tabla encontrada: " . $row["TABLE_NAME"] . "\n";

    // Cerrar la conexión
    $conn = null;
} catch (Exception $e) {
    echo "Error de conexión: " . $e->getMessage() . "\n";
}
