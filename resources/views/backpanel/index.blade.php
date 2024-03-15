<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Backpanel</title>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <div class="row">
        <div class="col-2" style='min-height:97.5vh;'>
            <h3 class="bg-dark text-white p-3 h-100">Back Panel 
                <div class="fs-5 align-items-end">
                    @include('backpanel.links')
                    <p > {{auth()->user()->roles[0]->name ?? 'Guest'}} : </p>
                    <p class="text-secondary">&nbsp;{{(auth()->user()->name) ?? 'Guest'}}</p>
                </div>
            </h3>
        </div>

        <div class="col-10">
            @yield('content')
        </div>
    </div>
    @yield('script')
</body>
</html>