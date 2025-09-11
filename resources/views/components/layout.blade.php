<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <x-head-basic />
</head>

<body class="container">
  {{ $slot }}
</body>

</html>