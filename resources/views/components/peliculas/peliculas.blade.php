@include('components.layout')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/peliculas.css">
    <script src="/js/Login.js"></script>
    <title>Peliculas</title>
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
    <br>
    <div class="row mt-3">
        <div class="col-12 col-lg-8 offset-0 offset-lg-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Añadir
            </button>
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                validar token
            </button>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 col-lg-8 offset-0 offset-lg-2">
            <div class="table-responsive; containerTable">
                <table class="table table-bordered table-hover table-light;tablesdiv">
                    <thead><tr class="table table-primary"><th>IMAGEN</th><th>TITULO</th><th>GENERO</th><th>DURACION</th><th>ACTUALIZAR</th><th>ELIMINAR</th></tr></thead>
                    <tbody class="table-group-divider table">
                        @foreach ($peliculas as $row)
                            <tr>
                                <td><img style="width: 100px;height:100px" src="{{$row->imagen}}" alt=""></td>
                                <td style="color: white">{{$row->titulo}}</td>
                                <td style="color: white">{{$row->genero}}</td>
                                <td style="color: white">{{$row->duracion}}</td>
                                <td>
                                    @if (Auth::user()->status_update == 1)
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#update-{{$row->id}}">
                                        Actualizar
                                    </button>
                                    @elseif (Auth::user()->rol_id == 1 || Auth::user()->rol_id == 2)
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#update-{{$row->id}}">
                                        Actualizar
                                    </button>
                                    @else
                                    <form  method="POST" action="{{url('tokengenerate/tokengen',[Auth::user()->id])}}"">
                                        @csrf
                                        <input type="text" name="method" style="display:none" value="update">
                                        <button type="submit" class="btn btn-primary">
                                            solicitar token
                                        </button>
                                    </form>
                                    @endif

                                    @include('components.modalsPeli.updatePelicula')

                                </td>
                                <td>
                                    @if (Auth::user()->status_delete == 1 && $row->status_delete == 1)
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-{{$row->id}}">
                                        Eliminar
                                    </button>
                                    @elseif (Auth::user()->rol_id == 1)
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-{{$row->id}}">
                                        Eliminar
                                    </button>
                                    @else
                                    <form action="{{url('tokengenerate/tokengen',[Auth::user()->id])}}" method="post">
                                        @csrf
                                        <input type="text" name="method" style="display:none" value="delete">
                                        <button type="submit" class="btn btn-danger">
                                            solicitar token
                                        </button>
                                    </form>
                                    @endif

                                    @include('components.modalsPeli.deletePelicula')

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('components.modalsPeli.addPelicula')
    @include('components.modalsPeli.validarToken')




</body>

</html>
