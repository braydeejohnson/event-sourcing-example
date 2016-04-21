@extends('app')

@section('content')
    <div class="ui container segment">
        <h1 class="ui header">Hello {{ $customer->firstName }} {{ $customer->lastName }}, </h1>
        <h2 class="ui header">Cart Summary</h2>
        <table class="ui celled compact table">
            <thead>
                <tr>
                    <th>Items In Cart</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customer->cart as $item)
                    <tr>
                        <td>{{ $item }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection