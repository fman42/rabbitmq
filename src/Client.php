<?php

namespace Ramm\RabbitmqClient;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Ramm\RabbitmqClient\Message\DefaultMessage;

class Client
{
    private $connectionString;

    private $exchange;

    /**
     * @param ConnectionString $connection
     * @param string $exchange
     */
    public function __construct($connectionString, $exchange = 'master')
    {
        $this->connectionString = $connectionString;
        $this->exchange = $exchange;
    }

    /**
     * Получить соединение к брокеру
     * Стоит прослойка через прокси RabbitMQ, что дает возможность создавать новое соединение на каждый запрос. Прокси сам будет придерживать short-live соединение
     * у себя внутри, чтоб его переиспользовать для остальных подключений php-процессов
     */
    public function getAMQP()
    {
        $connection = new AMQPStreamConnection(
            $this->getConnectionString()->getHost(),
            $this->getConnectionString()->getPort(),
            $this->getConnectionString()->getUser(),
            $this->getConnectionString()->getPassword(),
            '/'
        );

        return $connection;
    }

    /**
     * @param string $queue
     * @param [type] $callback
     *
     * @return void
     */
    public function consume($queue, $callback)
    {
        $connection = $this->getAMQP();
        $channel = $connection->channel();
        $channel->basic_consume($queue, $queue . '_consumer', false, false, false, false, $callback);

        register_shutdown_function(function () use ($connection, $channel) {
            $channel->close();
            $connection->close();
        });

        $channel->consume();
    }

    /**
     * @param string $eventName
     * @param array $payload
     *
     * @return void
     */
    public function publish($eventName, $payload)
    {
        $connection = $this->getAMQP();
        $channel = $connection->channel();

        $message = new DefaultMessage();
        $message->setEventName($eventName);
        $message->setPayload(json_encode($payload));

        $message = new AMQPMessage(json_encode($message->getSchemaAsArray()), array('content_type' => 'text/plain', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
        $channel->basic_publish($message, $this->exchange, strtolower($eventName));

        $channel->close();
        $connection->close();
    }

    /**
     * @return ConnectionString
     */
    public function getConnectionString()
    {
        return $this->connectionString;
    }
}
