<?php

namespace App\Aggregates\AggregateIds;


use App\Aggregates\Customer;

class CustomerId extends AggregateId
{
    public function type()
    {
        return class_basename(Customer::class);
    }
}