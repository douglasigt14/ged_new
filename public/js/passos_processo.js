 function mostrarModal(event) {
    const button = event.currentTarget
    const descricao = document.querySelector("#modalStatus #item-descricao")
    const id = document.querySelector("#modalStatus #item-id")
    
    var div_status_id = document.querySelector("#modalStatus #div-item-status_id")

    var div_tabela = document.querySelector("#modalStatus #div-item-tabela")

    var status_lista = JSON.parse(button.getAttribute("data-item-status_lista")); ;
    var status_lista_selecionados = JSON.parse(button.getAttribute("data-item-status_lista_selecionados")); ;


    if(status_lista.length == 0){
        div_status_id.innerHTML = '<span></span>';
    }
    else{
        div_status_id.innerHTML = '<select name="status_id" id="item-status_id" class="form-control"></select><br><center><button type="submit" class="btn btn-primary">Vincular</button></center>';

        var status_id = document.querySelector("#modalStatus #item-status_id")
            var op = '';
            status_lista.forEach(item => {
                op = op+'<option value="'+item.id+'">'+item.descricao+'</option>';
            });
            status_id.innerHTML = op;

    }
    if(status_lista_selecionados.length == 0){
        div_tabela.innerHTML = '<span></span>';
    }
    else{
        var tabela = '<table class="table table-striped"><thead><tr><th>Descrição</th><th class="center">Desvincular</th></tr></thead><tbody>';
        
        status_lista_selecionados.forEach(item => {
                href = "href='/desvincular/"+item.passos_status_id+"'";
                tabela = tabela+'<tr><td>'+item.descricao+'</td><td><center><a '+href+' class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></center></td></tr>';
        });

        tabela = tabela+'</tbody></table>'; 
            div_tabela.innerHTML = tabela;
    }
    
    

    

    descricao.innerHTML = button.getAttribute("data-item-descricao")
    id.value = button.getAttribute("data-item-id")

    // console.log();
}

 function mostrarModalDecissao(event) {
    const button = event.currentTarget
    const descricao = document.querySelector("#modalDecisao #item-descricao")
    const id = document.querySelector("#modalDecisao #item-id")

    descricao.innerHTML = button.getAttribute("data-item-descricao")
    id.value = button.getAttribute("data-item-id")
 }