@extends('commons.template')


@section('conteudo')
   
    <div class="row">
        <div class="col com-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3>Historico de Movimentações</h3>
                    <h4>Documento: {{$doc_descricao}}</h4>
                </div>
                <div class="panel-body">
                    <table class="table table-striped myTable">
										<thead>
											<tr>
                        <th>Data e Hora</th>
                        <th class='center'>De</th>
                        <th class='center'>Para</th>
                        <th class='center'>Usuario</th>
                      </tr>
										</thead>
										<tbody>
											@foreach ($hist_mov as $item)
											<tr>
                          <td>{{$item->systemdate }}</td>
                          <td class='center'>{{$item->nome_de }}</td>
                          <td class='center'>{{$item->nome_para }}</td>
                          <td class='center'>{{$item->rotulo }}</td>
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
              <form action="/status" method="post">
              @csrf
              <div class="col col-md-6">
                  <label>Descrição</label>
                  <input type="text" name='descricao' class='form-control' required autocomplete="off">
              </div>
              <div class="col col-md-6">
                  <label>Cor</label>
                  <input type="color" name='cor' class='form-control' required>
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
              <form action="/status" method="post">
              @csrf
              @method('put')
               <input type="hidden" id='item-id' name='id' class='form-control'>
              <div class="col col-md-6">
                  <label>Descrição</label>
                   <input type="text" id='item-descricao' name='descricao' class='form-control' required autocomplete="off">
              </div>
              <div class="col col-md-6">
                  <label>Cor</label>
                   <input type="color" id='item-cor' name='cor' class='form-control' required>
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
          $(document).ready( function () {
                    $('.myTable').DataTable();
         } );
         function mostrarModal(event) {
                const button = event.currentTarget
                const descricao = document.querySelector("#modalEditar #item-descricao")
                const id = document.querySelector("#modalEditar #item-id")
                const cor = document.querySelector("#modalEditar #item-cor")

                descricao.value = button.getAttribute("data-item-descricao")
                cor.value = button.getAttribute("data-item-cor")
                id.value = button.getAttribute("data-item-id")
            }
    </script>
@endpush
@endsection