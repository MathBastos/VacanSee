$(document).ready(function () {
    $.ajax({
        type: "GET",
        dataType: "json",
        data: "",
        url: "../php/buscaPerfilGerente.php",
        success: function (resultado) {
            document.getElementById("nome").value = resultado.nome;
        },
        error: function () {
        }
    });
});

document.addEventListener("DOMContentLoaded", function() {
    $.ajax({
        type: "GET",
        dataType: "json",
        data: "",
        url: "../php/valida_login.php",
        success: function (resultado) { 
            if (resultado == 2){
                alert("Faça o login primeiro!");
                window.location.replace("../html/index.html");
            }
        },
        error: function (){
        }
    });
});

function limpaIdQuarto() {
    $.ajax({
        type: "GET",
        dataType: "json",
        data: "",
        url: "../php/redirecionaquarto.php?id_quarto=-1",
        success: function (resultado) {
            window.location.replace("../html/cadastroquarto.html?id_quarto=-1");
        },
        error: function () {

        }
    });
}