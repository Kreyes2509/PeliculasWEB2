<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Verificar codigo</title>
</head>
<body>
    <h1>BIENVENID@:{{$name}}</h1>
    @if($tipo == 'update')
        <p>Token de autorizacion para actualizar es: <b>{{$token}}</b></p><br>
    @elseif ($tipo == 'delete')
        <p>Token de autorizacion para eliminar es: <b>{{$token}}</b></p><br>
    @endif
</body>
</html>
