
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

  <link rel="shortcut icon" type="image/png" href="/theme/assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="/theme/assets/css/styles.min.css" />
  <!-- Scripts -->
    
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body>
    <div id="app">
        @yield('content')
    </div>

  <script src="/theme/assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="/theme/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/theme/assets/js/sidebarmenu.js"></script>
  <script src="/theme/assets/js/app.min.js"></script>
  <script src="/theme/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="/theme/assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="/theme/assets/js/dashboard.js"></script>
</body>

</html>