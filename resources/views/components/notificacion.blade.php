@extends('components.layout')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" href="/css/notification.css">
    <title>Notificaciones</title>
</head>
<body>
    @section('container')
        @if (Auth::user()->rol_id == 1)
        <div class="row mt-3">
            <div class="col-12 col-lg-8 offset-0 offset-lg-2">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-light">
                        <thead><tr class="table-primary"><th>notificaciones eliminar</th><th></th></tr></thead>
                        <tbody class="table-group-divider">
                            @foreach ($tokendelete as $row)
                                @if ($row->status == 1)
                                <tr>
                                    <td>Generar Token de eliminar para el usuario:{{$row->name}}</td>
                                    <td>
                                        <form action="{{url('tokengenerate/tokengendelete',[$row->user_id])}}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">GENERAR</button>
                                        </form>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br><br>
        @endif
        <div class="row mt-3">
            <div class="col-12 col-lg-8 offset-0 offset-lg-2">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-light">
                        <thead><tr class="table-primary"><th>notificaciones actualizar</th><th></th></tr></thead>
                        <tbody class="table-group-divider">
                            @foreach ($tokenupdate as $row)
                             @if ($row->status == 1)
                                <tr>
                                    <td>Generar Token de actualizar para el usuario:{{$row->name}}</td>
                                    <td>
                                        <form action="{{url('tokengenerate/tokengenupdate',[$row->user_id])}}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">GENERAR</button>
                                        </form>
                                    </td>
                                </tr>
                             @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection
</body>
</html>
