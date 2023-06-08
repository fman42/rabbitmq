<?php

namespace Ramm\RabbitmqClient\Message;

interface MessageSchemaInterface
{
    /**
     * @param string $eventName
     * @return MessageSchemaInterface
     */
    public function setEventName($eventName);

    /**
     * @param string $eventName
     * @return MessageSchemaInterface
     */
    public function setPayload($payload);

    /**
     * @return array
     */
    public function getSchemaAsArray(): array;
}
