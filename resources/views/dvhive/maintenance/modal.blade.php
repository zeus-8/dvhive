<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('maintenance/find') }}" method="post">
            @csrf
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-10 offset-md-1">
                                @if ($resu)
                                    <table class="table table-hoverc table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Apellido</th>
                                                <th scope="col">Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($resu as $user)
                                                <tr>
                                                    <td>
                                                    </td>
                                                    <td>
                                                        {{ $user->name }}
                                                    </td>
                                                    <td>
                                                        {{ $user->surname }}
                                                        
                                                    </td>
                                                    <td>
                                                        {{ $user->id_career }}
                                                    </td>
                                                    <td>
                                                        <input type="radio" id="radioPrimary1" name="career" value="{{ $user->id_career }}">
                                                        <input type="hidden" name="document" value="{{ $user->pin }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table
                                @endif
                            
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>