<?php

namespace App\Aggregates;

use App\Aggregates\AggregateIds\CustomerId;
use App\DomainEvents\Customer\MembershipWasCreated;
use App\DomainEvents\Customer\ProductWasAddedToCart;
use App\DomainEvents\Customer\StartedShopping;
use Webpatser\Uuid\Uuid;

class Customer extends Aggregate
{
    public $firstName;
    public $lastName;
    public $email;
    public $cart;

    public static function create($firstName, $lastName, $email){
        $customer = new static();
        
        $customer->apply(new MembershipWasCreated(CustomerId::create(), [
            "customer" => [
                "firstName" => $firstName,
                "lastName" => $lastName,
                "email" => $email
            ]
        ]));

        return $customer;
    }

    protected function applyMembershipWasCreated(MembershipWasCreated $event){
        $this->aggregateId = $event->aggregateId();

        $customer = $event->customer();
        $this->firstName = $customer["firstName"];
        $this->lastName = $customer["lastName"];
        $this->email = $customer["email"];
    }

    public static function beginShopping(Customer $customer){
        $customer->apply(new StartedShopping(CustomerId::from($customer->aggregateId()), null));

        return $customer;
    }

    protected function applyStartedShopping(StartedShopping $event){
        //Check things for starting a session
        $this->cart = [];
    }

    public static function addProductToCart(Customer $customer, $product){
        $customer->apply(new ProductWasAddedToCart(CustomerId::from($customer->aggregateId()), [
            "product" => $product
        ]));

        return $customer;
    }

    protected function applyProductWasAddedToCart(ProductWasAddedToCart $event){
        $this->cart[] = $event->product();
    }

}