<?php

namespace App\Aggregates;


use App\DomainEvents\DomainEvent;

abstract class Aggregate
{
    protected $aggregateId;

    protected $eventsToPersist = [];

    protected $appliedEvents = [];

    protected $version;

    public function aggregateId(){
        return $this->aggregateId;
    }

    public function aggregateName(){
        return class_basename($this);
    }

    /**
     * Returns a list of events to persist to the event store
     *
     * @return DomainEvent[] array
     */
    public function eventsToPersist()
    {
        return $this->eventsToPersist;
    }

    public function clearEvents()
    {
        $this->eventsToPersist = [];
    }

    /**
     * Apply all events to initialize state of this aggregate
     *
     * @param $events
     */
    public function initialize($events)
    {
        //Reapply Events
        array_map([$this, 'apply'], $events);

        //They've already been persisted, start fresh
        $this->clearEvents();
    }


    public function apply(DomainEvent $event){
        $this->handle($event);

        $this->eventsToPersist[] = $event;
        $this->appliedEvents[] = $event->id();
    }

    /**
     * Resolve the Domain Events specific handle method on this aggregate
     *
     * @param DomainEvent $event
     */
    protected function handle(DomainEvent $event)
    {
        $method = 'apply' . class_basename($event);

        if(! method_exists($this, $method)){
            return;
        }

        $this->$method($event);
    }


}