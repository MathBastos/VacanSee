function limpaIdAcessorio(){
    $.ajax({
        type: "GET",
        dataType: "json",
        data: "",
        url: "../php/redirecionaAcessorio.php?id_acessorio=-1",
        success: function (resultado) {
            window.location.replace("../html/cadastroAcessorio.html?id_acessorio=-1");
        },
        error: function (){
            
        }
    });
}
function limpaIdVeiculo() {
    $.ajax({
        type: "GET",
        dataType: "json",
        data: "",
        url: "../php/redirecionaVeiculo.php?id_veiculo=-1",
        success: function (resultado) {
            window.location.replace("../html/cadastroVeiculo.html?id_veiculo=-1");
        },
        error: function () {

        }
    });
}