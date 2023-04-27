<!-- Modal -->
<div class="modal fade" id="update-{{$row->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Actualizar pelicula</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{url("peli/updatepeli",[$row])}}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-graduation-cap"></i></span>
                    <input type="text" value="{{$row->titulo}}" name="titulo" class="form-control" placeholder="Titulo" aria-label="Username" aria-describedby="basic-addon1">
                    @error('titulo')
                    <br><small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-graduation-cap"></i></span>
                    <textarea name="descripcion" class="form-control" placeholder="descripcion" aria-label="Username" style="height: 150px">{{$row->descripcion}}</textarea>
                    @error('descripcion')
                    <br><small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-graduation-cap"></i></span>
                    <input type="text" value="{{$row->genero}}" name="genero" class="form-control" placeholder="genero" aria-label="Username" aria-describedby="basic-addon1">
                    @error('genero')
                    <br><small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-graduation-cap"></i></span>
                    <input type="text" value="{{$row->duracion}}" name="duracion" class="form-control" placeholder="duracion" aria-label="Username" aria-describedby="basic-addon1">
                    @error('duracion')
                    <br><small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-graduation-cap"></i></span>
                    <input type="file" value="{{$row->imagen}}" name="imagen" class="form-control" placeholder="imagen" aria-label="Username" aria-describedby="basic-addon1">
                    @error('imagen')
                    <br><small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="d-grid col-6 mx-auto">
                    <button class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
                </div>
            </form>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        </div>
    </div>
    </div>
</div>
