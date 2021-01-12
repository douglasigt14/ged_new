@extends('commons.template')


@section('conteudo')
   
    <div class="row">
        <div class="col com-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Setores</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                         <div class="col col-md-11"></div>
                         <div class="col col-md-1">
                             <center><button data-toggle="modal" data-target="#modalInserir" class="btn btn-circle btn-success"><i class="fa fa-plus"></i></button></center>
                         </div>
                    </div>
                     <table class="table table-striped">
										<thead>
											<tr>
												<th>Setor</th>
												<th>Pasta</th>
												<th class='center'>Editar</th>
												<th class='center'>Excluir</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($setores as $item)
											<tr>
											    <td>{{$item->descricao }}</td>
												<td>{{$item->pasta }}</td>
                                                <td>
                                                    
                                                    <center><button 
                                                        data-toggle="modal" 
                                                        data-target="#modalEditar" 
                                                        onclick="mostrarModal(event)"
                                                        data-item-id={{$item->id}}
                                                        data-item-descricao='{{$item->descricao}}'
                                                        data-item-pasta='{{$item->pasta}}'
                                                        class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button></center>
                                                </td>
                                                <td>
                                                  <form action="/setores" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden" name="id" value={{$item->id}}>
                                                    
                                                    <center><button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button></center>
                                                  </form>
                                                </td>
											</tr>
											@endforeach
										</tbody>
									</table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
<div class="modal fade" id="modalInserir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Inserir</h4>
      </div>
      <div class="modal-body">
          <div class="row">
              <form action="/setores" method="post">
              @csrf
              <div class="col col-md-6">
                  <label>Setor</label>
                  <input type="text" name='descricao' class='form-control' required>
              </div>
              <div class="col col-md-6">
                  <label>Pasta</label>
                  <input type="text" name='pasta' class='form-control'>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Inserir</button>
      </form>
      </div>
    </div>
  </div>
</div>


   <!-- Modal -->
<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Editar</h4>
      </div>
      <div class="modal-body">
          <div class="row">
              <form action="/setores" method="post">
              @csrf
              @method('put')
               <input type="hidden" id='item-id' name='id' class='form-control'>
              <div class="col col-md-6">
                  <label>Setor</label>
                 
                   <input type="text" id='item-descricao' name='descricao' class='form-control' required>
              </div>
              <div class="col col-md-6">
                  <label>Pasta</label>
                  <input type="text" id='item-pasta' name='pasta' class='form-control'>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-warning">Editar</button>
      </form>
      </div>
    </div>
  </div>
</div>
@push('scripts')
    <script>
         function mostrarModal(event) {
                const button = event.currentTarget
                const pasta = document.querySelector("#modalEditar #item-pasta")
                const descricao = document.querySelector("#modalEditar #item-descricao")
                const id = document.querySelector("#modalEditar #item-id")

                pasta.value = button.getAttribute("data-item-pasta")
                descricao.value = button.getAttribute("data-item-descricao")
                id.value = button.getAttribute("data-item-id")
            }
    </script>
@endpush
@endsection