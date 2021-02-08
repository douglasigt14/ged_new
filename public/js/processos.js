$(document).ready( function () {
    $('.myTable').DataTable();
} );
function mostrarModal(event) {
const button = event.currentTarget
const descricao = document.querySelector("#modalEditar #item-descricao")
const id = document.querySelector("#modalEditar #item-id")
const ativo = document.querySelector("#modalEditar #item-ativo")

descricao.value = button.getAttribute("data-item-descricao")
id.value = button.getAttribute("data-item-id")


opcoes = [...ativo.options]
opcoes.forEach(function (opcao) {
    if (opcao.innerText.trim() == button.getAttribute("data-item-ativo").trim()) {
      ativo.selectedIndex = opcao.index 
    }else{
    }
})

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