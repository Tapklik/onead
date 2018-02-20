<!DOCTYPE html>
<html lang="en" class="smart-style-tapklik">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    
    <title>@yield('page-title', 'Tapklik')</title>

    <link rel="stylesheet" href="/css/materialdesignicons.min.css" />    

    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

    <link href='//fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">

    <link rel="stylesheet" href="/css/vuetify.css" />

    <link rel="stylesheet" href="/css/app.css" />
    <script>
        window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token()]); ?>
    </script>
    
    @yield('head-scripts')
    <script>
     @yield('head-js')
    </script>
</head>
<body class="@yield('body-class')">
    @yield('master-content')

    @yield('footer-elements')

    @yield('footer-scripts')
</body>
</html>
