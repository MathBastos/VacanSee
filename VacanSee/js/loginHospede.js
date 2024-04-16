const loginHospede = document.getElementById("loginHospedeForm");
var usuario = document.getElementById('usuario');

loginHospede.addEventListener("submit", async (e) => {

    if( usuario.value == "admin"){
        window.location.replace("../html/indexAdm.html");
    }

    e.preventDefault();
    const dadosForm = new FormData(loginHospede);
    dadosForm.append("add", 1);

    const dados = await fetch("../php/loginHospede.php", {
        method: "POST",
        body: dadosForm,
    });
    const resposta = await dados.json();
    
    if(resposta == "bloqueado"){
        alert("Este usuário está bloqueado! Para desbloqueio entrar em contato com administrador.");
    } 

    if(resposta == "sucesso"){
        window.location.replace("../html/indexHospede.html");
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
        url: "../php/redirecionaHospede.php?id_hospede=-1",
        success: function (resultado) {
            window.location.replace("../html/cadastroHospede.html?id_hospede=-1");
        },
        error: function () {

        }
    });
}