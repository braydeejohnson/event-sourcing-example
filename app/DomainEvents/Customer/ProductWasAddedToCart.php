<?php

namespace App\DomainEvents\Customer;


use App\DomainEvents\DomainEvent;

class ProductWasAddedToCart extends DomainEvent
{
    public function product()
    {
        return $this->payload["product"];
    }
}