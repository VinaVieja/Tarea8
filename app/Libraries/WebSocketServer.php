<?php

namespace App\Libraries;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class WebSocketServer implements MessageComponentInterface
{
    protected $clients;
    protected $pdo; // PDO opcional

    public function __construct($pdo = null)
    {
        $this->clients = new \SplObjectStorage;
        if ($pdo instanceof \PDO) {
            $this->pdo = $pdo;
        } else {
            $this->pdo = null;
        }
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "Nueva conexión: {$conn->resourceId}\n";

        // Mensaje de bienvenida opcional solo al cliente nuevo
        $welcome = json_encode(['system' => 'Conectado al servidor WebSocket.']);
        $conn->send($welcome);
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        // Seguridad: intentar decodificar JSON y validar
        $data = json_decode($msg, true);
        if (!is_array($data)) {
            // si no es JSON, ignorar o enviar error
            $from->send(json_encode(['system' => 'Formato de mensaje no válido. Use JSON.']));
            return;
        }

        $user = isset($data['user']) ? trim($data['user']) : 'Anon';
        $text = isset($data['msg']) ? trim($data['msg']) : '';

        if ($text === '') {
            $from->send(json_encode(['system' => 'Mensaje vacío no enviado.']));
            return;
        }

        // Guardar en BD si está disponible (opcional)
        if ($this->pdo instanceof \PDO) {
            try {
                $stmt = $this->pdo->prepare("INSERT INTO mensajes (usuario, mensaje, creado_en) VALUES (:u, :m, NOW())");
                $stmt->execute([':u' => $user, ':m' => $text]);
            } catch (\Exception $e) {
                // No detener el flujo por errores de BD; loguear
                echo "Error guardando mensaje en BD: " . $e->getMessage() . "\n";
            }
        }

        // Preparar payload para enviar a todos los clientes (broadcast)
        $payload = json_encode([
            'user' => $user,
            'msg'  => $text,
            'time' => date('Y-m-d H:i:s')
        ]);

        foreach ($this->clients as $client) {
            // enviar a todos (incluyendo el remitente) — si quieres excluir al remitente, compara $from !== $client
            $client->send($payload);
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
