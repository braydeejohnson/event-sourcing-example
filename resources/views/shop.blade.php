@extends('app')

@section('content')
    <h1 class="ui header">Hello {{ $customer->firstName }} {{ $customer->lastName }}, </h1>
    <div class="ui clearing segment">
        <div class="ui right floated button"><a href="/checkout">Checkout Cart ({{ count($customer->cart) }})</a></div>
    </div>
    <div class="ui raised segment">
        <div class="ui four column grid">
            @for ($i = 0; $i < 4; $i ++)
            <div class="ui column">
                <form method="post" action="/add/{{ $i }}" class="ui form">
                    {{ csrf_field() }}
                    <span>Product {{ $i }}</span>
                    <button class="ui fluid blue button">Add To Cart</button>
                </form>
            </div>
            @endfor
        </div>
    </div>


@endsection