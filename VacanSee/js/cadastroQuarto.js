const cadQuarto = document.getElementById("cadastroQuarto");

cadQuarto.addEventListener("submit", async (e) => {
    e.preventDefault();
    const dadosForm = new FormData(cadQuarto);
    dadosForm.append("add", 1);
    
    const dados = await fetch("../php/cadastroQuarto.php", {
        method: "POST",
        body: dadosForm,
    });

    const resposta = await dados.json();
    swal(resposta);

    if (resposta == "Usuario cadastrado com sucesso!"){
        location.href = 'indexGerente.html'
    }
});