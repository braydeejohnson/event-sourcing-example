<?php

namespace App\Http\Controllers;

use App\Aggregates\AggregateIds\CustomerId;
use App\Aggregates\Customer;
use App\Commands\Customer\BeginShoppingSession;
use App\Commands\Customer\CreateMembership;
use App\EventStore;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MainController extends Controller
{

    /**
     * @var EventStore
     */
    private $eventStore;

    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    public function home(){
        return view('welcome');
    }

    public function join(Request $request){
        $customer = [
            "firstName" => $request->get('firstName'),
            "lastName" => $request->get('lastName'),
            "email" => $request->get('email'),
        ];

        $newMembership = new CreateMembership($this->eventStore, $customer);

        $customer = $newMembership->execute();
        
        if($customer){
            $startShopping = new BeginShoppingSession($this->eventStore, $customer);
            $startShopping->execute();
        }
        
        return redirect("/shop");
    }
    
    public function load(Request $request, $id){
        dd($this->eventStore->load($id, Customer::class));
    }

    public function shop(Request $request){
        $customer = $this->eventStore->load(session("customerId"), Customer::class);

        return view('shop')->with([
            "customer" => $customer
        ]);
    }

    public function add(Request $request, $productId){
        $customer = $this->eventStore->load(session("customerId"), Customer::class);
        $product = "Product $productId";

        $customer = Customer::addProductToCart($customer, $product);
        $this->eventStore->save($customer);

        return redirect("/shop");
    }

    public function checkout()
    {
        $customer = $this->eventStore->load(session("customerId"), Customer::class);

        return view('checkout')->with([
            "customer" => $customer
        ]);
    }
}
