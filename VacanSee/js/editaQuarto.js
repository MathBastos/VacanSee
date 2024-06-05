function editaQuarto(){
    $.ajax({
        type: "GET",
        dataType: "json",
        data: "",
        url: "../php/buscaQuarto.php",
        success: function (resultado) {
            document.getElementById("andar").value = resultado.modelo;
            document.getElementById("numero").value = resultado.marca;
            document.getElementById("tipo_cama").value = resultado.ano;
            document.getElementById("qtd_cama").value = resultado.cambio;
            document.getElementById("qtd_banheiro").value = resultado.direcao;
            document.getElementById("banheira").value = resultado.categoria;
            document.getElementById("ar_condicionado").value = resultado.chassi;
            document.getElementById("servico_quarto").value = resultado.placa;
            document.getElementById("cafe_manha").value = resultado.cor;
            document.getElementById("valor_dia").value = resultado.motor;
        },
        error: function (){
            
        }
    });
}