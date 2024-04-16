function editaHospede(){
    $.ajax({
        type: "GET",
        dataType: "json",
        data: "",
        url: "../php/buscaHospede.php",
        success: function (resultado) {
            console.log(resultado);
            document.getElementById("nome").value = resultado.nome ;
            document.getElementById("cpf").value = resultado.cpf;
            document.getElementById("dataNasc").value = resultado.data_nascimento;
            document.getElementById("celular").value = resultado.celular;
            document.getElementById("email").value = resultado.email;
            document.getElementById("usuario").value = resultado.usuario;
        },
        error: function (){
            console.log(resultado);
        }
    });
    
}