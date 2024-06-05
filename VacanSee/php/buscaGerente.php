<?php
include_once "conexao.php";
session_start();
$id_hotel = $_SESSION["id_hotel"];

if($id_hotel > 0){
    $query = 
    "SELECT 
     hotel.id_hotel
    ,nome
    ,cnpj
    ,telefone
    ,email
    ,cep
    ,rua
    ,numero
    ,estado
    ,bairro
    ,cidade
    ,complemento
    ,usuario
    ,senha 
    FROM usuario 
        INNER JOIN hotel 
            ON usuario.id_usuario = hotel.id_usuario 
        INNER JOIN hotel_endereco 
            ON hotel.id_hotel = hotel_endereco.id_hotel 
        INNER JOIN endereco 
            ON hotel_endereco.id_endereco = endereco.id_endereco
    WHERE hotel.id_hotel = :id_hotel
    ";


    $resultado = $conn->prepare($query);
    $resultado->bindParam(':id_hotel', $id_hotel);
    $resultado->execute();


    $row = $resultado->fetch(PDO::FETCH_ASSOC);
    $retorno["id"] = $row["id_hotel"];
    $retorno["nome"] = $row["nome"];
    $retorno["cnpj"] = $row["cnpj"];
    $retorno["telefone"] = $row["telefone"];
    $retorno["email"] = $row["email"];
    $retorno["cep"] = $row['cep'];
    $retorno["rua"] = $row["rua"];
    $retorno["numero"] = $row["numero"];
    $retorno["estado"] = $row["estado"];
    $retorno["bairro"] = $row["bairro"];
    $retorno["cidade"] = $row['cidade'];
    $retorno["complemento"] = $row["complemento"];
    $retorno["usuario"] = $row["usuario"];
    

}else{
    $retorno["id"] = "";
    $retorno["nome"] = "";
    $retorno["cnpj"] = "";
    $retorno["telefone"] = "";
    $retorno["email"] = "";
    $retorno["cep"] = "";
    $retorno["rua"] = "";
    $retorno["numero"] = "";
    $retorno["estado"] = "";
    $retorno["bairro"] = "";
    $retorno["cidade"] = "";
    $retorno["complemento"] = "";
    $retorno["usuario"] = "";
    $retorno["senha"] = "";
}
echo json_encode($retorno);