$(document).ready(function () {
    $.ajax({
        type: "GET",
        dataType: "json",
        data: "",
        url: "../php/controleQuarto.php",
        success: function (resultado) {

            var html = "<table class='table' itemborder='1'>";

            html += "<tr>";
            html += "<td align='center'>" + "ID" + "</td>";
            html += "<td align='center'>" + "Andar" + "</td>";
            html += "<td align='center'>" + "Numero" + "</td>";
            html += "<td align='center'>" + "Editar" + "</td>";
            html += "<td align='center'>" + "Excluir" + "</td>";
            html += "</tr>";

            for (var i = 0; i < resultado.length; i++) {
                html += "<tr>";
                html += "<td align='center'>" + resultado[i].id + "</td>";
                html += "<td align='center'>" + resultado[i].andar + "</td>";
                html += "<td align='center'>" + resultado[i].numero + "</td>";
                html += "<td align='center'> <a onclick='editaQuarto(" + resultado[i].id + ")'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i></td>";
                html += "<td align='center'> <a onclick='deleteQuarto("+ resultado[i].id +")'> <i class='fas fa-trash-alt' aria-hidden='true'></i> </td>";
                html += "</tr>";
            }
            html += "</table>";
            html += "<br>";

            $("#table").html(html);
        }
    });
});


function deleteQuarto(id){
    $.ajax({
        type: "GET",
        dataType: "json",
        data: "",
        url: "../php/deletaQuarto.php?id_quarto="+id,
        success: function (resultado) {
            alert("Quarto removido com sucesso!");
            window.location.reload();
        },
        error: function (){
            
        }
    });
}

function editaQuarto(id) {
    $.ajax({
        type: "GET",
        dataType: "json",
        data: "",
        url: "../php/redirecionaQuarto.php?id_quarto=" + id,
        success: function (resultado) {
            window.location.replace("../html/cadastroQuarto.html?id_quarto=" + id);
        },
        error: function () {

        }
    });


}