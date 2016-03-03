<?php

namespace App;

use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * Class that manages the consumption of messages from the RabbitMQ server queue.
 *
 * @author Jose Manuel García Maleno <josemanuel.garcia@unidadeditorial.es>
 */
class Consumer
{
    protected $host;
    protected $port;
    protected $user;
    protected $pass;
    protected $queue;

    /**
     * Consumer constructor.
     *
     * @param string $host  Hostname of the RabbitMQ server.
     * @param int    $port  Port of the RabbitMQ server.
     * @param string $user  User name of the RabbitMQ server.
     * @param string $pass  Password for the user in the RabbitMQ server.
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
     * Consume messages from the RabbitMQ server queue.
     */
    public function readMessages()
    {
        // Connect to the RabbitMQ server.
        $connection = new AMQPStreamConnection($this->host, $this->port, $this->user, $this->pass);
        $channel = $connection->channel();
        $channel->basic_qos(null, 1, null); // Gives one message to a consumer at a time.

        // Create the queue if not exists and connect to it.
        $channel->queue_declare($this->queue, false, true, false, false); // Persistent queue.

        echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

        // Method that will consume the messages.
        $callback = function ($msg) {
            echo " [x] Received ", $msg->body, "\n";

            // ToDo: Process the message, send back the result to the origin.

            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);

            echo " [x] Consumed ", $msg->body, "\n";
        };

        // Consume the message.
        $channel->basic_consume($this->queue, '', false, false, false, false, $callback);

        // Wait for messages.
        while (\count($channel->callbacks)) {
            $channel->wait();
        }

        // Close connection.
        $channel->close();
        $connection->close();
    }
}
