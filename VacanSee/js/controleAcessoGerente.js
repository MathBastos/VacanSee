$(document).ready(function () {
    $.ajax({
        type: "GET",
        dataType: "json",
        data: "",
        url: "../php/controleAcessoGerente.php",
        success: function (resultado) {

            var html = "<table class='table' itemborder='1'>";

            html += "<tr>";
            html += "<td align='center'>" + "ID" + "</td>";
            html += "<td align='center'>" + "Nome" + "</td>";
            html += "<td align='center'>" + "CNPJ" + "</td>";
            html += "<td align='center'>" + "Editar" + "</td>";
            html += "<td align='center'>" + "Bloqueado" + "</td>";
            html += "<td align='center'>" + "Deletar" + "</td>";
            html += "</tr>";

            for (var i = 0; i < resultado.length; i++) {
                html += "<tr>";
                html += "<td align='center'>" + resultado[i].id + "</td>";
                html += "<td align='center'>" + resultado[i].nome + "</td>";
                html += "<td align='center'>" + resultado[i].cnpj + "</td>";
                html += "<td align='center'> <a onclick='editGerente(" + resultado[i].id + ")'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i></td>";
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
            alert("Usuario bloqueado com sucesso!");
            window.location.reload();
        },
        error: function (){
            alert("Usuario bloqueado com sucesso!");
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
            alert("Usuario desbloqueado com sucesso!");
            window.location.reload();
        },
        error: function (){
            alert("Usuario desbloqueado com sucesso!");
            window.location.reload();
        }
    });
}

function editGerente(id) {
    console.log(id)
    $.ajax({
        type: "GET",
        dataType: "json",
        data: "",
        url: "../php/redirecionaGerente.php?id_gerente=" + id,
        success: function (resultado) {
            window.location.replace("../html/cadastroGerente.html?id_hotel=" + id);
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
        url: "../php/deletaGerente.php?id_usuario="+id,
        success: function (resultado) {
            $.ajax({
                type: "GET",
                dataType: "json",
                data: "",
                url: "../php/deletaUsuario.php?id_usuario="+id,
                success: function (resultado) {
                    alert("Usuário removido com sucesso!");
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

