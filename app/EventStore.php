<?php

namespace App;


use App\Aggregates\Aggregate;
use App\Aggregates\AggregateIds\AggregateId;
use Carbon\Carbon;
use Jenssegers\Mongodb\Connection;

class EventStore
{

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function save(Aggregate $aggregate)
    {
        $eventStream = $this->db->collection($aggregate->aggregateName());
        foreach($aggregate->eventsToPersist() as $event){
            $eventStream->insert($event->serialize());

            //Publish Event...
        }

        $aggregate->clearEvents();
    }

    public function load($aggregateId, $aggregateClass)
    {
        /** @var Aggregate $aggregate */
        $aggregate = new $aggregateClass();

        $events = $this->loadEvents($aggregate, $aggregateId);
        $aggregate->initialize($events);

        return $aggregate;
    }

    private function loadEvents(Aggregate $aggregate, $aggregateId)
    {
        $events = $this->db->collection($aggregate->aggregateName())->where([
            "aggregateId" => $aggregateId,
            "aggregateType" => class_basename($aggregate)
        ])->get();

        return array_map(function($event){
            return $event["event"]::deserialize($event);
        }, $events);
    }
}