<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{csrf_token()}}" />
        <script>window.Laravel = {csrfToken: "{{csrf_token()}}"}</script>

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css" >

    </head>
    <body>
        <div id="app">
            <div class="container">
                <passport-clients></passport-clients>
            </div>
        </div>
        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
}
