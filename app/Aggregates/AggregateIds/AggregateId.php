<?php

namespace App\Aggregates\AggregateIds;

use Webpatser\Uuid\Uuid;

abstract class AggregateId
{
    protected $id;

    /**
     * AggregateId constructor.
     * @param $id
     */
    protected function __construct($id){
        $this->id = $id;
    }

    /**
     * @return AggregateId
     */
    public static function create()
    {
        $class = get_called_class();
        return new $class(Uuid::generate());
    }

    /**
     * @param $id
     * @return AggregateId
     */
    public static function from($id)
    {
        $class = get_called_class();
        return new $class($id);
    }

    abstract public function type();

    public function __toString(){
        return (string) $this->id;
    }
}