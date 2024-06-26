$(document).ready(function () {
    $.ajax({
        type: "GET",
        dataType: "json",
        data: "",
        url: "../php/controleAcessoHospede.php",
        success: function (resultado) {

            var html = "<table class='table' itemborder='1'>";

            html += "<tr>";
            html += "<td align='center'>" + "ID" + "</td>";
            html += "<td align='center'>" + "Nome" + "</td>";
            html += "<td align='center'>" + "CPF" + "</td>";
            html += "<td align='center'>" + "Editar" + "</td>";
            html += "<td align='center'>" + "Bloqueado" + "</td>";
            html += "<td align='center'>" + "Deletar" + "</td>";
            html += "</tr>";

            for (var i = 0; i < resultado.length; i++) {
                html += "<tr>";
                html += "<td align='center'>" + resultado[i].id + "</td>";
                html += "<td align='center'>" + resultado[i].nome + "</td>";
                html += "<td align='center'>" + resultado[i].cpf + "</td>";
                html += "<td align='center'> <a onclick='editHospede(" + resultado[i].id + ")'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i></td>";
                if (resultado[i].flag_bloqueado == "N"){
                    html += "<td align='center'> <a onclick='block(" + resultado[i].id_usuario + ")'><i class='fa fa-lock' aria-hidden='true'></i></a></td>";
                }else{
                    html += "<td align='center'> <a onclick='unblock(" + resultado[i].id_usuario + ")'><i class='fa fa-unlock' aria-hidden='true'></i></a></td>";
                }
                html += "<td align='center'> <a onclick='deleteUsuario("+ resultado[i].id_usuario +")'> <i class='fas fa-trash-alt' aria-hidden='true'></i> </td>";
                html += "</tr>";
            }
            html += "</table>";
            html += "<br>";

            $("#table").html(html);
        }
    });
});

function block(id){
    $.ajax({
        type: "GET",
        dataType: "json",
        data: "",
        url: "../php/bloqueioAcesso.php?id_usuario="+id,
        success: function (resultado) {
            swal("Usuario bloqueado com sucesso!");
            window.location.reload();
        },
        error: function (){
            swal("Usuario bloqueado com sucesso!");
            window.location.reload();
            
        }
    });
}

function unblock(id){
    $.ajax({
        type: "GET",
        dataType: "json",
        data: "",
        url: "../php/desbloqueioAcesso.php?id_usuario="+id,
        success: function (resultado) {
            swal("Usuario desbloqueado com sucesso!");
            window.location.reload();
        },
        error: function (){
            swal("Usuario desbloqueado com sucesso!");
            window.location.reload();
        }
    });
}

function editHospede(id) {
    console.log(id)
    $.ajax({
        type: "GET",
        dataType: "json",
        data: "",
        url: "../php/redirecionaHospede.php?id_hospede=" + id,
        success: function (resultado) {
            window.location.replace("../html/cadastroHospede.html?id_hospede=" + id);
        },
        error: function () {

        }
    });
}

function deleteUsuario(id){
    
    $.ajax({
        type: "GET",
        dataType: "json",
        data: "",
        url: "../php/deletaHospede.php?id_usuario="+id,
        success: function (resultado) {
            $.ajax({
                type: "GET",
                dataType: "json",
                data: "",
                url: "../php/deletaUsuario.php?id_usuario="+id,
                success: function (resultado) {
                    swal("Usuário removido com sucesso!");
                    window.location.reload();
                },
                error: function (){ 
                }
            });
        },
        error: function (){ 
        }
    });
    

}   

