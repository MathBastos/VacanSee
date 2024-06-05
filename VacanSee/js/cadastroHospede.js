const cadHospede = document.getElementById("cadastroHospede");

cadHospede.addEventListener("submit", async (e) => {
    e.preventDefault();
    const dadosForm = new FormData(cadHospede);
    dadosForm.append("add", 1);
    
    const dados = await fetch("../php/cadastroHospede.php", {
        method: "POST",
        body: dadosForm,
    });

    const resposta = await dados.json();
    swal(resposta);

    if (resposta == "Usuario cadastrado com sucesso!"){
        location.href = 'loginHospede.html'
    }
});

function formatar(mascara, documento) {
    var i = documento.value.length;
    var saida = mascara.substring(0, 1);
    var texto = mascara.substring(i);

    if (texto.substring(0, 1) != saida) {
        documento.value += texto.substring(0, 1);
    }

}