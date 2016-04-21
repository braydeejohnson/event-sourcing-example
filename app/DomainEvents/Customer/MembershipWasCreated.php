<?php

namespace App\DomainEvents\Customer;

use App\DomainEvents\DomainEvent;

class MembershipWasCreated extends DomainEvent
{
    public function customer(){
        return $this->payload["customer"];
    }
}