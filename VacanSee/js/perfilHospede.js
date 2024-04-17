$(document).ready(function () {
    $.ajax({
        type: "GET",
        dataType: "json",
        data: "",
        url: "../php/perfilHospede.php",
        success: function (resultado) {
            document.getElementById("nome").value = resultado.nome;
            document.getElementById("celular").value = resultado.celular;
            document.getElementById("email").value = resultado.email;
        },
        error: function () {
        }
    });
});