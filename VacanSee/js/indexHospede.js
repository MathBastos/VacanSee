function editaHospede(){
    $.ajax({
        type: "GET",
        dataType: "json",
        data: "",
        url: "../php/buscaHospede.php",
        success: function (resultado) {
            console.log(resultado);
            document.getElementById("nome").value = resultado.nome;
        },
        error: function (){
            console.log(resultado);
        }
    });
}