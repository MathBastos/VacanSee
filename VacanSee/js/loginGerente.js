const loginGerente = document.getElementById("loginGerenteForm");
var usuario = document.getElementById('usuario');

loginGerente.addEventListener("submit", async (e) => {

    if( usuario.value == "admin"){
        window.location.replace("../html/indexAdm.html");
    }

    e.preventDefault();
    const dadosForm = new FormData(loginGerente);
    dadosForm.append("add", 1);

    const dados = await fetch("../php/login.php", {
        method: "POST",
        body: dadosForm,
    });
    const resposta = await dados.json();
    
    if(resposta == "bloqueado"){
        alert("Este usuário está bloqueado! Para desbloqueio entrar em contato com administrador.");
    } 

    if(resposta == "sucesso"){
        window.location.replace("../html/indexGerente.html");
    }
    if(resposta == "erro"){
        alert("Oops, tem algo errado! Verifique suas credenciais.");
    }
});

function limpaId() {
    $.ajax({
        type: "GET",
        dataType: "json",
        data: "",
        url: "../php/redirecionaGerente.php?id_hotel=-1",
        success: function (resultado) {
            window.location.replace("../html/cadastroGerente.html?id_hotel=-1");
        },
        error: function () {

        }
    });
}