<?php

namespace App\Libraries;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class WebSocketServer implements MessageComponentInterface
{
    protected $clients;
    protected $pdo;  // Conexión PDO a BD

    public function __construct($pdo)
    {
        $this->clients = new \SplObjectStorage;
        $this->pdo = $pdo;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "Nueva conexión: {$conn->resourceId}\n";
        $conn->send(json_encode(['type' => 'system', 'message' => 'Bienvenido al chat!']));
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        try {
            $data = json_decode($msg, true);
            if ($data['type'] === 'message') {
                $username = $data['username'] ?? 'Anónimo';
                $message = $data['message'] ?? '';
                $averiaId = $data['averia_id'] ?? null;
                $timestamp = date('Y-m-d H:i:s');

                // Solo guarda en BD si hay averia_id (chat específico)
                if ($averiaId) {
                    $stmt = $this->pdo->prepare("INSERT INTO mensajes (averia_id, username, message, created_at) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$averiaId, $username, $message, $timestamp]);
                } else {
                    // Para chat público, no guardar en BD, solo transmitir
                    echo "Mensaje público recibido: {$username}: {$message}\n";
                }

                // Envía a todos los clientes conectados
                foreach ($this->clients as $client) {
                    $client->send(json_encode([
                        'type' => 'message',
                        'username' => $username,
                        'message' => $message,
                        'timestamp' => $timestamp,
                        'averia_id' => $averiaId,
                    ]));
                }
            }
        } catch (\Exception $e) {
            echo "Error procesando mensaje: {$e->getMessage()}\n";
            $from->send(json_encode(['type' => 'system', 'message' => 'Error interno.']));
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Conexión cerrada: {$conn->resourceId}\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }
}