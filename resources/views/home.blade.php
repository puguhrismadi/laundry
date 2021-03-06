<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body 
            {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }
            .full-height 
            {
                height: 100vh;
            }
            .flex-center 
            {
                align-items: center;
                display: flex;
                justify-content: center;
            }
            .position-ref 
            {
                position: relative;
            }
            .top-right 
            {
                position: absolute;
                right: 10px;
                top: 18px;
            }
            .content 
            {
                text-align: center;
            }
            .title {
                font-size: 84px;
                font-weight: bold;
            }
            .links > a 
            {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: bold;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
            .m-b-md 
            {
                margin-bottom: 30px;
            }
            .middle 
            {
                margin-left: auto;
                margin-right: auto;
            }
            .table-font 
            {
                color: grey;
                font-size: 20px;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
            <div class="top-right links">
                <a href="{{ url('about') }}">About Us</a>
                @auth
                @if (Auth::user()->role == 'staff')
                <a href="{{ url('admin') }}">Admin Console</a>
                @else
                <a href="{{ url('user_orders/create') }}">Book Order</a>
                <a href="{{ url('user_orders')}}">My Orders</a>
                <a href="{{ url('profile') }}">My Profile</a>
                <a href="{{ url('history') }}">Purchased History</a>
                @endif
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
                @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
            @endif

            <div class="content">
                <div class="title">Online Laundry Booking</div>
                <div>
                    <h2>Estimate your laundry cost.</h2>
                    <form action="{{ url('user/orders') }}" method="POST" >
                        {!! csrf_field() !!}
                        <table class="middle table-font">
                            <tr>
                                <td>Laundry (kg)</td>
                                <td><input type="number" name="laundry" min="0" id="laundry" onchange="changeTotal()" /></td>
                            </tr>
                            <tr>
                                <td>Ironing (kg)</td>
                                <td><input type="number" name="ironing" min="0" id="ironing" onchange="changeTotal()" /></td>
                            </tr>
                            <tr>
                                <td>Price</td>
                                <td id="total">0$</td>
                            </tr>
                        </table>
                    </form>
                    <h2>Register to experience the most convenient laundry service. </h2>
                    <table class="middle table-font">
                        <tr>
                            <td><img src="/images/1.png" width="200px" height="200px" /></td>
                            <td><img src="/images/2.png" width="200px" height="200px" /></td>
                            <td><img src="/images/3.png" width="200px" height="200px" /></td>
                        </tr>
                        <tr>
                            <td>Quality Guarantee</td>
                            <td>Expert</td>
                            <td>Free Delivery</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <!-- Scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/ajax.js') }}"></script>
    </body>
</html>
