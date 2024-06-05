$(document).ready(function () {

    $.ajax({
        type: "GET",
        dataType: "json",
        data: "",
        url: "../php/indexHospede.php",
        success: function (resultado) {

            var html = "<table class='table' itemborder='1'>";

            html += "<tr>";
            html += "<td align='center'>" + "Nome do Hotel" + "</td>";
            html += "<td align='center'>" + "Andar" + "</td>";
            html += "<td align='center'>" + "Diária (R$)" + "</td>";
            html += "<td align='center'>" + "" + "</td>";
            html += "</tr>";

            for (var i = 0; i < resultado.length; i++) {
                html += "<tr>";
                html += "<td align='center'>" + resultado[i].nome + "</td>";
                html += "<td align='center'>" + resultado[i].andar + "</td>";
                html += "<td align='center'>" + resultado[i].valor_dia + "</td>";
                html += "<td align='center'> <a onclick='reservarQuarto(" + resultado[i].id + ")'> <i class='fa fa-shopping-cart' aria-hidden='true'></i></td>";
                html += "</tr>";
            }
            html += "</table>";
            html += "<br>";

            $("#table").html(html);
        }
    });   

});

document.addEventListener("DOMContentLoaded", function() {
    const timeElement = document.getElementById('time');
    const now = new Date();
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const seconds = now.getSeconds().toString().padStart(2, '0');
    const timeString = `${hours}:${minutes}:${seconds}`;
    timeElement.textContent = timeString;

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

function filtrar (){
    var html = "<table class='table' itemborder='1'>";

    html += "<tr>";
    html += "<td align='center'>" + "" + "</td>";
    html += "<td align='center'>" + "Andar" + "</td>";
    html += "<td align='center'>" + "Diária" + "</td>";
    html += "</tr>";



    var filtro = document.getElementById("pesquisa").value
    
    $.ajax({
        type: "GET",
        dataType: "json",
        data: "",
        url: "../php/filtroQuarto.php?filtro=" + filtro,
        success: function (resultado) {
            for (var i = 0; i < resultado.length; i++) {
                html += "<tr>";
                html += "<td width='20%' align='center'>" + "<img width='100%' src=" + resultado[i].imagem + "></img>" + "</td>";
                html += "<td align='center'>" + resultado[i].andar + "</td>";
                html += "<td align='center'>" + resultado[i].nome + "</td>";
                html += "<td align='center'>" + resultado[i].valor_dia + "</td>";
                html += "<td align='center'> <a onclick='alugarQuarto(" + resultado[i].id + ")'> <i class='fa fa-shopping-cart' aria-hidden='true'></i></td>";
                html += "</tr>";
            }
            html += "</table>";
            html += "<br>";

            $("#table").html(html);
        },
        error: function (resultado) {
            console.log(resultado[0]);
        }
    });

    $("#table").html(html);
}

function reservarQuarto(id) {
    $.ajax({
        type: "GET",
        dataType: "json",
        data: "",
        url: "../php/redirecionaReserva.php?id_quarto=" + id,
        success: function (resultado) {
            window.location.replace("../html/reservaQuarto.html?id_quarto=" + id);
        },
        error: function () {

        }
    });
}