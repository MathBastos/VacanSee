function editaQuarto(){
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
            document.getElementById("banheira").value = resultado.banheira;
            document.getElementById("ar_condicionado").value = resultado.ar_condicionado;
            document.getElementById("servico_quarto").value = resultado.servico_quarto;
            document.getElementById("cafe_manha").value = resultado.cafe_manha;
            document.getElementById("valor_dia").value = resultado.valor_dia;
        },
        error: function (){
            
        }
    });
}