var id_reserva;
var id_atual;
$(document).ready(function () {
    
    $.ajax({
        type: "GET",
        dataType: "json",
        data: "",
        url: "../php/controleReserva.php",
        success: function (resultado) {
            var html = "<table class='table' itemborder='1'>";
            
            html += "<tr>";
            html += "<td align='center'>" + "Hospede" + "</td>";
            html += "<td align='center'>" + "Andar" + "</td>";
            html += "<td align='center'>" + "Numero quarto" + "</td>";
            html += "<td align='center'>" + "De" + "</td>";
            html += "<td align='center'>" + "Até" + "</td>";
            html += "<td align='center'>" + "Valor reserva (R$)" + "</td>";
            html += "<td align='center'>" + "Cancelar" + "</td>";
            html += "</tr>";
            
            for (var i = 0; i < resultado.length; i++) {
                var dataInput1 = resultado[i].dia_entrada;
                var dataInput2 = resultado[i].dia_saida;
    
                dataInicio = new Date(dataInput1);
                dataInicioFormatada = dataInicio.toLocaleDateString('pt-BR', { timeZone: 'UTC' });
                id_reserva = resultado[i].id

                dataFim = new Date(dataInput2);
                dataFimFormatada = dataFim.toLocaleDateString('pt-BR', { timeZone: 'UTC' });
                html += "<tr>";
                html += "<td align='center'>" + resultado[i].nome + "</td>";
                html += "<td align='center'>" + resultado[i].andar + "</td>";
                html += "<td align='center'>" + resultado[i].numero + "</td>";
                html += "<td align='center'>" + dataInicioFormatada + "</td>";
                html += "<td align='center'>" + dataFimFormatada + "</td>";
                html += "<td align='center'>" + resultado[i].valor + "</td>";
                html += "<td align='center'> <a onclick='deleteReserva(" + resultado[i].id +")'> <i class='fas fa-times' aria-hidden='true'></i> </td>";
                html += "</tr>";
            }
            html += "</table>";
            html += "<br>";

            $("#table").html(html);
        }
    });
});

function deleteReserva(id){

    $.ajax({
        type: "GET",
        dataType: "json",
        data: "",
        url: "../php/deletaReserva.php?id_reserva="+id,
        success: function (resultado) {
            alert("Reserva removida com sucesso!");
            window.location.reload();
        },
        error: function (){   
        }
    });
}

function salvaID(id){
    id_atual = id;
}
