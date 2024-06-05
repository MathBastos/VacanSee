function editaGerente(){
    $.ajax({
        type: "GET",
        dataType: "json",
        data: "",
        url: "../php/buscaGerente.php",
        success: function (resultado) {
            console.log(resultado);
            document.getElementById("nome").value = resultado.nome ;
            document.getElementById("cnpj").value = resultado.cnpj;
            document.getElementById("telefone").value = resultado.telefone;
            document.getElementById("email").value = resultado.email;
            document.getElementById("usuario").value = resultado.usuario;
            document.getElementById("cep").value = resultado.cep;
            document.getElementById("rua").value = resultado.rua;
            document.getElementById("numero").value = resultado.numero;
            document.getElementById("estado").value = resultado.estado;
            document.getElementById("bairro").value = resultado.bairro;
            document.getElementById("cidade").value = resultado.cidade;
            document.getElementById("complemento").value = resultado.complemento;
        },
        error: function (){
            console.log(resultado);
        }
    });
    
}