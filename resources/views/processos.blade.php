@extends('commons.template')


@section('conteudo')
   
    <div class="row">
        <div class="col com-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Processos</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                         <div class="col col-md-11"></div>
                         <div class="col col-md-1">
                             <center><button data-toggle="modal" data-target="#modalInserir" class="btn btn-circle btn-success"><i class="fa fa-plus"></i></button></center>
                         </div>
                    </div><br>
                     <table class="table table-striped myTable">
										<thead>
											<tr>
                        <th>Descrição</th>
                        <th class='center'>Situação</th>
                        <th class='center'>Fluxo</th>
                        <th class='center'>Bpmn</th>
												<th class='center'>Img</th>
												<th class='center'>Editar</th>
												<th class='center'>Excluir</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($processos as $item)
											<tr>
                          <td>{{$item->descricao }}</td>
                          <td class="center">{{$item->ativo }}</td>
                            <td>
                              
                              <center><a  href='/passos_processo/{{$item->id}}' class="btn btn-sm btn-primary"><i class="fa fa-arrows-alt"></i></a></center>
                          </td>
                           <td>
                              
                              <center><button 
                                  data-toggle="modal" 
                                  data-target="#modalBpmn" 
                                  onclick="mostrarModalBpmn(event)"
                                  data-item-id={{$item->id}}
                                  data-item-xml='{{$item->xml}}'
                                  class="btn btn-sm btn-info"><i class="fa fa-file-code-o"></i></button></center>
                          </td>
                           <td>
                              
                              <center><button 
                                  data-toggle="modal" 
                                  data-target="#modalImg" 
                                  onclick="mostrarModalImg(event)"
                                  data-item-id={{$item->id}}
                                  data-item-img='{{$item->img}}'
                                  class="btn btn-sm btn-info"><i class="fa fa-file-image-o"></i></button></center>
                          </td>
                          <td>
                              
                              <center><button 
                                  data-toggle="modal" 
                                  data-target="#modalEditar" 
                                  onclick="mostrarModal(event)"
                                  data-item-id={{$item->id}}
                                  data-item-descricao='{{$item->descricao}}'
                                  class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button></center>
                          </td>
                          <td>
                            <form action="/processos" method="post">
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
          <form action="/processos" method="post" enctype="multipart/form-data">
              @csrf
          <div class="row">
              <div class="col col-md-12">
                  <label>Descrição</label>
                  <input type="text" name='descricao' class='form-control' required autocomplete="off">
              </div>
          </div><br>
          <div class="row">
              <div class="col col-md-6">
                  <label>BPMN</label>
                  <input type="file" name='bpmn' class='form-control' required>
              </div>
              <div class="col col-md-6">
                  <label>IMG</label>
                  <input type="file" name='img' class='form-control' required>
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
              <form action="/processos" method="post">
              @csrf
              @method('put')
               <input type="hidden" id='item-id' name='id' class='form-control'>
              <div class="col col-md-12">
                  <label>Descrição</label>
                 
                   <input type="text" id='item-descricao' name='descricao' class='form-control' required autocomplete="off">
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


<div class="modal fade" id="modalImg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Imagem</h4>
      </div>
      <div class="modal-body">
          <div class="row">
             <div class="col col-md-12">
                    <source id="item-source-img" srcset="" type="image/svg+xml">
                    <img id="item-img" src="" class="img-fluid img-thumbnail" alt="...">
             </div>
          </div>
      </div>
      <div class="modal-footer">
      </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalBpmn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">BPMN</h4>
      </div>
      <div class="modal-body">
          <div class="row">
             <div class="col col-md-12">
                <textarea id="item-xml" readonly='true' class='form-control' name="story" rows="5" cols="33"> </textarea>    
             </div>
          </div>
      </div>
      <div class="modal-footer">
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

                descricao.value = button.getAttribute("data-item-descricao")
                id.value = button.getAttribute("data-item-id")
            }

          function mostrarModalImg(event) {
               
                const button = event.currentTarget
                const img = document.querySelector("#modalImg #item-img")
                const source_img = document.querySelector("#modalImg #item-source-img")
                 console.log(img);

                img.srcset = button.getAttribute("data-item-img")
                source_img.src = button.getAttribute("data-item-img")
            }
            

             function mostrarModalBpmn(event) {
               
                const button = event.currentTarget
                const xml = document.querySelector("#modalBpmn #item-xml")

                xml.innerHTML = button.getAttribute("data-item-xml")
            }

    </script>
@endpush
@endsection