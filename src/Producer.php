<?php

namespace App;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class that manages the creation and sending of messages to the RabbitMQ server queue.
 *
 * @author Jose Manuel García Maleno <josemanuel.garcia@unidadeditorial.es>
 */
class Producer
{
    protected $host;
    protected $port;
    protected $user;
    protected $pass;
    protected $queue;

    /**
     * Producer constructor.
     *
     * @param string $host Hostname of the RabbitMQ server.
     * @param int    $port Port of the RabbitMQ server.
     * @param string $user User name of the RabbitMQ server.
     * @param string $pass Password for the user in the RabbitMQ server.
     * @param string $queue Queue name to use. If it doesn't exists, it will be created.
     *
     * @author Jose Manuel García Maleno <josemanuel.garcia@unidadeditorial.es>
     */
    public function __construct($host, $port, $user, $pass, $queue)
    {
        $this->host  = $host;
        $this->port  = $port;
        $this->user  = $user;
        $this->pass  = $pass;
        $this->queue = $queue;
    }

    /**
     * Sends a message to the RabbitMQ server queue with the given data.
     *
     * @param mixed The data to be sent in the message.
     */
    function sendMessage($data = null)
    {
        // Connect to the RabbitMQ server.
        $connection = new AMQPStreamConnection($this->host, $this->port, $this->user, $this->pass);
        $channel = $connection->channel();

        // Create the queue if not exists and connect to it.
        $channel->queue_declare($this->queue, false, true, false, false); // Persistent queue.

        // Create and send the message.
        $msg = new AMQPMessage($data, array('delivery_mode' => 2)); // Persistent message.
        $channel->basic_publish($msg, '', $this->queue);

        // Close connection.
        $channel->close();
        $connection->close();
    }
}
