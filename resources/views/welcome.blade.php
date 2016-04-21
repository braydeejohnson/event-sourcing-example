@extends('app')

@section('content')
    <h1 class="ui header">Membership Sign Up</h1>
    <form method="POST" action="/join" class="ui form">
        {{ csrf_field() }}
        <div class="field">
            <label>First Name</label>
            <input type="text" name="firstName" placeholder="First Name">
        </div>
        <div class="field">
            <label>Last Name</label>
            <input type="text" name="lastName" placeholder="Last Name">
        </div>
        <div class="field">
            <label>Email</label>
            <input type="email" name="email" placeholder="Email">
        </div>
        <div class="field">
            <div class="ui checkbox">
                <input type="checkbox" tabindex="0" class="hidden">
                <label>I agree to the Terms and Conditions</label>
            </div>
        </div>
        <button class="ui button" type="submit">Submit</button>
    </form>
@endsection