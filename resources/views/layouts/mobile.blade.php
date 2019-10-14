<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <title>{{ config('app.name', 'Laravel') }}</title> -->

    <!-- Scripts -->
    <script src="{{ asset('js/m/appmobile.js') }}"></script>

    <!-- <script src="http://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script> -->

    <!-- Styles -->
    <link href="{{ asset('css/m/appmobile.css') }}" rel="stylesheet">

</head>
<body>
    <div class="container">
        @yield('content')
    </div>

    <script type="text/javascript">
        //window.onload = setFocus;

        //var el = document.getElementById('InputBarCode');
        //if (el !== null)
        //{
        //    el.onpaste = setPasteInputBarCode;
        //}
        @yield('scripts')
    </script>
</body>
</html>
