<?php

namespace App\Commands\Customer;


use App\Aggregates\Customer;
use App\Commands\Command;
use App\EventStore;

class CreateMembership extends Command
{
    protected $eventStore;
    protected $firstName;
    protected $lastName;
    protected $email;

    public function __construct(EventStore $eventStore, $membershipData)
    {
        $this->eventStore = $eventStore;
        $this->firstName = $membershipData["firstName"];
        $this->lastName = $membershipData["lastName"];
        $this->email = $membershipData["email"];
    }

    public function execute()
    {
        $customer = Customer::create($this->firstName, $this->lastName, $this->email);

        $this->eventStore->save($customer);

        return $customer;
    }
}