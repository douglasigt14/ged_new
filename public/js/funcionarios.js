$(document).ready( function () {
    $('.myTable').DataTable();
} );
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