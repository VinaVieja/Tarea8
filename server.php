<?php
$config = require __DIR__ . '/config/db.php';

try {
    $dsn = "mysql:host={$config['host']};dbname={$config['database']};port={$config['port']};charset=utf8";
    $pdo = new PDO($dsn, $config['username'], $config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión a BD exitosa.\n";
} catch (PDOException $e) {
    die("Error de conexión a BD: " . $e->getMessage() . "\n");
}

require_once __DIR__ . '/vendor/autoload.php';

use App\Libraries\WebSocketServer;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new WebSocketServer($pdo) 
        )
    ),
    8080
);

echo "Servidor WebSocket corriendo en ws://127.0.0.1:8080\n";
$server->run();