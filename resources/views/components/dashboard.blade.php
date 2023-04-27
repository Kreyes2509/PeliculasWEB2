@include('components.layout')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/dashboard.css">
    <script src="/js/Login.js"></script>
    <title>Dashboard</title>
</head>
<body>
    @if ($message = Session::get('msg'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{$message}}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @section('container')

    @endsection
    <h1>Bienvenido al WEB2</h1>
</body>

</html>
