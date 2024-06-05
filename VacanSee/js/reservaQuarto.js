var quarto;
var valor_reserva;
var dt1;
var dt2;
var data_inicio;
var data_fim;

function buscaQuarto(){
    $.ajax({
        type: "GET",
        dataType: "json",
        data: "",
        url: "../php/buscaQuarto.php",
        success: function (resultado) {
            document.getElementById("andar").value = resultado.andar;
            document.getElementById("numero").value = resultado.numero;
            document.getElementById("tipo_cama").value = resultado.tipo_cama;
            document.getElementById("qtd_cama").value = resultado.qtd_cama;
            document.getElementById("qtd_banheiro").value = resultado.qtd_banheiro;
            document.getElementById("banheira").value = resultado.banheira;//(resultado.banheira == 's' ? "Sim" : "Não" );
            document.getElementById("ar_condicionado").value = resultado.ar_condicionado;//(resultado.ar_condicionado == 's' ? "Sim" : "Não" );
            document.getElementById("servico_quarto").value = resultado.servico_quarto;//(resultado.servico_quarto == 's' ? "Sim" : "Não" );
            document.getElementById("cafe_manha").value = resultado.cafe_manha;//(resultado.cafe_manha == 's' ? "Sim" : "Não" );
            document.getElementById("valor_dia").value = resultado.valor_dia;

            quarto = resultado;
        },
        error: function (){
        }
    });
}

function calcular(){
    data_entrada = document.getElementById("data_entrada").value;
    data_saida = document.getElementById("data_saida").value;

    dt1 = new Date(data_entrada+'T00:00:00Z');
    dt2 = new Date(data_saida+'T00:00:00Z');

    var dif = dt2.getTime() - dt1.getTime();

    // To calculate the no. of days between two dates
    var dif_dia = dif / (1000 * 3600 * 24);
    
    valor_reserva = quarto.valor_dia * dif_dia;

    document.getElementById("valorTotal").value = valor_reserva;
}

function reservar() {
    $.ajax({
        type: "POST",
        data: {
            valorReserva: valor_reserva,
            dataEntrada: data_entrada,
            dataSaida: data_saida,
            id_quarto: quarto.id_quarto,
        },
        url: "../php/reservaQuarto.php",
        async: false,
        success: function (resultado) {
            swal("Quarto Reservado com sucesso!");
            location.href = 'indexHospede.html'
        },
        error: function () {
            swal("Não foi possível reservar o Quarto, tente novamente!")
        }
    });
}