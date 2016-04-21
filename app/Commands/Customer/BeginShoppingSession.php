<?php

namespace App\Commands\Customer;


use App\Aggregates\AggregateIds\CustomerId;
use App\Aggregates\Customer;
use App\Commands\Command;
use App\EventStore;

class BeginShoppingSession extends Command
{
    /**
     * @var EventStore
     */
    protected $eventStore;
    /**
     * @var Customer
     */
    private $customer;


    public function __construct(EventStore $eventStore, Customer $customer)
    {
        $this->eventStore = $eventStore;
        $this->customer = $customer;
    }

    public function execute()
    {
        $customer = Customer::beginShopping($this->customer);

        $this->eventStore->save($customer);

        session([
            "customerId" => (string)$customer->aggregateId()
        ]);
    }
}