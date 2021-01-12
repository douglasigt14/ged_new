@extends('commons.template')


@section('conteudo')
   
    <div class="row">
        <div class="col com-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Funcionarios</h3>
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
												<th>Rotulo</th>
                        <th>Nome</th>
                        <th>Setor</th>
                        <th class='center'>Senha</th>
                        <th class='center'>Editar</th>
												<th class='center'>Excluir</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($funcionarios as $item)
											<tr>
											  <td>{{$item->rotulo }}</td>
                        <td>{{$item->nome }}</td>
                        <td>{{$item->setor }}</td>
                        <td>
                            
                            <center><button 
                                data-toggle="modal" 
                                data-target="#modalSenha" 
                                onclick="mostrarModalSenha(event)"
                                data-item-senha-id={{$item->id}}
                                data-item-descricao='{{$item->rotulo}}'
                                data-item-pasta='{{$item->nome}}'
                                class="btn btn-sm btn-info"><i class="fa fa-key"></i></button></center>
                        </td>
                        <td>
                            
                            <center><button 
                                data-toggle="modal" 
                                data-target="#modalEditar" 
                                onclick="mostrarModal(event)"
                                data-item-id={{$item->id}}
                                data-item-rotulo='{{$item->rotulo}}'
                                data-item-nome='{{$item->nome}}'
                                data-item-setor='{{$item->setor}}'
                                class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button></center>
                        </td>
                        <td>
                          <form action="/funcionarios" method="post">
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
          <form action="/funcionarios" method="post" onsubmit="onAddOperator(event)">
              @csrf
          <div class="row">
              <div class="col col-md-4">
                  <label>Rotulo</label>
                  <input type="text" name='rotulo' class='form-control' required>
              </div>
              <div class="col col-md-4">
                  <label>Nome</label>
                  <input type="text" name='nome' class='form-control' required>
              </div>
              <div class="col col-md-4">
                  <label>Setor</label>
                  <select name="setor_id" id="cars" class='form-control' required>
                    <option></option>
                    @foreach ($setores as $item)
                          <option value="{{$item->id}}">{{$item->descricao}}</option>
                    @endforeach
                  </select>
              </div>
          </div>
          <br>
          <div class="row">
              <div class="col col-md-6">
                  <label>Senha</label>
                  <input type="password" name='senha' class='form-control' required>
              </div>
              <div class="col col-md-6">
                  <label>Confirmar Senha</label>
                  <input type="password" name='confirmar_senha' class='form-control' required>
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
              <form action="/funcionarios" method="post">
              @csrf
              @method('put')
               <input type="hidden" id='item-id' name='id' class='form-control'>
              <div class="col col-md-4">
                  <label>Rotulo</label>
                 
                   <input type="text" id='item-rotulo' name='rotulo' class='form-control' required> 
              </div>
              <div class="col col-md-4">
                  <label>Nome</label>
                  <input type="text" id='item-nome' name='nome' class='form-control' required>
              </div>
               <div class="col col-md-4">
                  <label>Setor</label>
                  <select name="setor_id" id="item-setor_id" class='form-control' required>
                    <option></option>
                    @foreach ($setores as $item)
                          <option value="{{$item->id}}">{{$item->descricao}}</option>
                    @endforeach
                  </select>
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


<!-- Modal -->
<div class="modal fade" id="modalSenha" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Mudar Senhar</h4>
      </div>
      <div class="modal-body">
          <div class="row">
              <form action="/funcionarios" method="post" onsubmit="onAddOperator(event)">
              @csrf
              @method('patch')
               <input type="hidden" id='item-senha-id' name='id' class='form-control'>
              <div class="col col-md-6">
                  <label>Nova Senha</label>
                 
                   <input type="password" type="text" name='senha' class='form-control' required>
              </div>
              <div class="col col-md-6">
                  <label>Confirmar Nova Senha</label>
                  <input type="password"  name='confirmar_senha' class='form-control' required>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-info">Alterar</button>
      </form>
      </div>
    </div>
  </div>
</div>
@push('scripts')
    <script>
         function mostrarModal(event) {
                const button = event.currentTarget
                const rotulo = document.querySelector("#modalEditar #item-rotulo")
                const nome = document.querySelector("#modalEditar #item-nome")
                const id = document.querySelector("#modalEditar #item-id")
                const setor_id = document.querySelector("#modalEditar #item-setor_id")

                rotulo.value = button.getAttribute("data-item-rotulo")
                nome.value = button.getAttribute("data-item-nome")
                id.value = button.getAttribute("data-item-id")

                

                opcoes = [...setor_id.options]
                opcoes.forEach(function (opcao) {
                    if (opcao.innerText.trim() == button.getAttribute("data-item-setor").trim()) {
                        setor_id.selectedIndex = opcao.index 
                    }else{
                        console.log('false')
                    }
                })
            }


            function mostrarModalSenha(event) {
                const button = event.currentTarget
                const id = document.querySelector("#modalSenha #item-senha-id")
                id.value = button.getAttribute("data-item-senha-id")
            }

             function onAddOperator(e) {
              e.preventDefault()

              const form = e.target;
              if(form.senha.value !== form.confirmar_senha.value) {
                  alert("As senhas devem ser iguais")
              } else {
                  form.submit();
              }

          }
    </script>
@endpush
@endsection