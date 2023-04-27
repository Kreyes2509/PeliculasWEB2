<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" href="/css/Login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <title>Login</title>
</head>
<body>
    @if ($message = Session::get('msg'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{$message}}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="padre">
        <div class="login"style="text-align: center;width: 50%">
            <form method="POST" action="{{url("session")}}" style="width: 50%">
                <h1>Login WEB2</h1>
                @csrf
                <div class="mb-3">
                    <input type="text" name="email" placeholder="email" required="required" />
                    @error('email')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="password" name="password" placeholder="Password" required="required" />
                    @error('password')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-large">Iniciar sesion</button><br>
            </form>
        </div>
</body>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
                // Enable pusher logging - don't include this in production
                Pusher.logToConsole = true;

                var pusher = new Pusher('5160c8cff0011923445c', {
                cluster: 'us2'
                });

                var channel = pusher.subscribe('home');
                channel.bind('my-event', function(data) {
                let mensaje = JSON.stringify(data);
                console.log(mensaje)
                console.log('ya jala pendejo')
            });
      </script>

</html>
