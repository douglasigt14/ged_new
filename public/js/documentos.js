
$(document).ready( function () {
    $('.myTable').DataTable({
        "pageLength": 100,
        "order": [[ 3, "asc" ]]
    });
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

Array.from(document.querySelectorAll('.btn-seguir')).forEach(
    function(button){
        button.addEventListener('click',function(e){
            e.preventDefault();
            id_doc = button.getAttribute("data-item-id");
            

            Swal.fire({
            title: 'Deseja Realmente seguir o fluxo para o proximo passo ?',
            showCancelButton: true,
            //width: 600,
            confirmButtonColor: '#3ca512',
            cancelButtonColor: '#d9534f',
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não'
            }).then((result) => {
            if (result.isConfirmed) {
                 document.getElementById("form-seguir-"+id_doc).submit();
            }
            })
        });
    }
);

Array.from(document.querySelectorAll('.btn-seguir-inicio')).forEach(
    function(button){
        button.addEventListener('click',function(e){
            e.preventDefault();
             id_doc = button.getAttribute("data-item-id");
            
             Swal.fire({
            title: 'Deseja iniciar o Fluxo com esse processo ?',
            showCancelButton: true,
            confirmButtonColor: '#3ca512',
            cancelButtonColor: '#d9534f',
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não'
            }).then((result) => {
            if (result.isConfirmed) {
                 document.getElementById("form-seguir-inicio-"+id_doc).submit();
            }
            })
            
            
        });
    }
);

function mostrarModalDesvincularProcesso (event) {
    const button = event.currentTarget
    const descricao = document.querySelector("#modalDesvincularProcesso #item-descricao")
    const caminho_svg = document.querySelector("#modalDesvincularProcesso #item-caminho_svg")
    const id = document.querySelector("#modalDesvincularProcesso #item-id")

    descricao.innerHTML = button.getAttribute("data-item-descricao")
    id.value = button.getAttribute("data-item-id")
    caminho_svg.value = button.getAttribute("data-item-caminho_svg")
 }