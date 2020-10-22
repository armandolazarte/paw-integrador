<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Sistema Control</title>
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
  <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}">
</head>
<body class="grid-container">
      @include('partials.header')
      @include('partials.sidenav')
      @include('partials.main')
      @include('partials.footer')
      @stack('scripts')
      <script>
        var url = "{{  url('/')}}";
      </script>
      <script src="{{asset('js/main.js')}}"></script>
</body>
</html>
