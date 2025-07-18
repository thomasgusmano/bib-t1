<?php
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require __DIR__ . '/vendor/autoload.php';

class UserCounter implements MessageComponentInterface {
    protected $clients;
    protected $count = 0;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        $this->count++;
        $this->broadcastCount();
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        $this->count--;
        $this->broadcastCount();
    }

    public function onMessage(ConnectionInterface $from, $msg) {}
    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }

    private function broadcastCount() {
        foreach ($this->clients as $client) {
            $client->send($this->count);
        }
    }
}

$server = Ratchet\Server\IoServer::factory(
    new Ratchet\Http\HttpServer(
        new Ratchet\WebSocket\WsServer(
            new UserCounter()
        )
    ),
    8080
);

$server->run();
