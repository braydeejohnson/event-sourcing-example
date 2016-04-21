<?php

namespace App\DomainEvents;

use App\Aggregates\AggregateIds\AggregateId;
use Carbon\Carbon;
use Webpatser\Uuid\Uuid;

abstract class DomainEvent
{
    protected $id;
    protected $aggregateId;
    protected $aggregateType;
    protected $payload;
    protected $timestamp;

    public function __construct(AggregateId $aggregateId, $payload)
    {
        $this->id = Uuid::generate();
        $this->aggregateId = $aggregateId;
        $this->aggregateType = $aggregateId->type();
        $this->payload = $payload;
    }

    public function id() {
        return (string)$this->id;
    }

    public function aggregateId() {
        return $this->aggregateId;
    }

    /**
     * Serializes the event for storing in the EventStore
     *
     * @return array
     */
    public function serialize()
    {
        return [
            "id" => (string) $this->id,
            "aggregateId" => (string) $this->aggregateId,
            "aggregateType" => $this->aggregateType,
            "event" => static::class,
            "payload" => $this->payload,
            "timestamp" => new Carbon()
        ];
    }

    /**
     * Deserialize the event for use in the application
     *
     * @param $serializedEvent
     * @return static
     */
    public static function deserialize($serializedEvent)
    {
        $aggregateIdClass = "App\\Aggregates\\AggregateIds\\" . $serializedEvent["aggregateType"] . "Id";
        $aggregateId = $aggregateIdClass::from($serializedEvent["aggregateId"]);

        $event = new static(
            $aggregateId,
            $serializedEvent["payload"]
        );

        $event->id = $serializedEvent["id"];
        $event->aggregateType = $aggregateId->type();
        $event->timestamp = $serializedEvent["timestamp"];

        return $event;
    }
}