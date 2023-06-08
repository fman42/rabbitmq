<?php

namespace Ramm\RabbitmqClient\Message;

class DefaultMessage implements MessageSchemaInterface
{
    /** @var string */
    private $eventName = '';

    /** @var string */
    private $payload = '';

    /** @var string */
    private $version = '1.0.0';

    /** 
     * @param string $version
     */
    public function __construct($version = '1.0.0')
    {
        $this->version = $version;
    }

    /**
     * @param string $eventName
     * @return DefaultMessage
     */
    public function setEventName($eventName): DefaultMessage
    {
        $this->eventName = $eventName;

        return $this;
    }

    /**
     * @param string $payload
     * @return DefaultMessage
     */
    public function setPayload($payload): DefaultMessage
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * @return array
     */
    public function getSchemaAsArray(): array
    {
        return [
            'eventName' => $this->eventName,
            'message' => [
                'payload' => $this->payload,
                'version' => $this->version
            ],
            'dateTime' => date('Y-m-d H:i:s')
        ];
    }
}
