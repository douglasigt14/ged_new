
$(document).ready( function () {
    $('.myTable').DataTable();
} );

$('.dropify').dropify({
    messages: {
        'default': 'Arraste e solte um arquivo aqui ou clique',
        'replace': 'Arraste e solte ou clique para substituir',
        'remove':  'Remover',
        'error':   'Opa, algo errado aconteceu.'
    }
});


    $(function() {
    $('#toggle-finalizados').change(function() {
        finalizados = $('#toggle-finalizados').prop('checked') ? "/1" : "/0";
        outros_setores = $('#toggle-outros_setores').prop('checked') ? "/1" : "/0";
        window.location.href = "/documentos"+finalizados+""+outros_setores;
    })
})
$(function() {
    $('#toggle-outros_setores').change(function() {
        finalizados = $('#toggle-finalizados').prop('checked') ? "/1" : "/0";
        outros_setores = $('#toggle-outros_setores').prop('checked') ? "/1" : "/0";
        window.location.href = "/documentos"+finalizados+""+outros_setores;
    })
})
function mostrarModalImg(event) {     
        const button = event.currentTarget
        const img = document.querySelector("#modalImg #item-img")
        const source_img = document.querySelector("#modalImg #item-source-img")
        console.log(img);

        img.srcset = button.getAttribute("data-item-img")
        source_img.src = button.getAttribute("data-item-img")
}

function mostrarModalStatus(event) {     
        const button = event.currentTarget
        const id = document.querySelector("#modalStatus #item-id")
        const status_lista = document.querySelector("#modalStatus #item-status_lista")

        var lista = JSON.parse(button.getAttribute("data-item-status_lista")) 

            var op = '';
        lista.forEach(item => {
            op = op+'<option value="'+item.id+'">'+item.descricao+'</option>';
        });
            status_lista.innerHTML = op;
        
        id.value = button.getAttribute("data-item-id")
}
function mostrarModalDecisao(event) {     
    const button = event.currentTarget
    const id = document.querySelector("#modalDecissao #item-id")
    const pergunta = document.querySelector("#modalDecissao #item-pergunta")
    const bifurcacoes = document.querySelector("#modalDecissao #item-bifurcacoes")
    const processo_id = document.querySelector("#modalDecissao #item-processo_id")
    const setor_atual_id = document.querySelector("#modalDecissao #item-setor_atual_id")

    var lista = JSON.parse(button.getAttribute("data-item-bifurcacoes")) 

        var op = '';
    lista.forEach(item => {
        op = op+'<option value="'+item.id+'">'+item.nome+'</option>';
    });
        bifurcacoes.innerHTML = op;

    id.value = button.getAttribute("data-item-id")
    pergunta.innerHTML = button.getAttribute("data-item-pergunta")
    processo_id.value = button.getAttribute("data-item-processo_id")
    setor_atual_id.value = button.getAttribute("data-item-setor_atual_id")
    
    
}