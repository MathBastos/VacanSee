<?php
include_once "conexao.php";
session_start();
$id_quarto = $_SESSION["id_quarto"];
if($id_quarto > 0){
    $query = 
    "SELECT
    id_quarto
    ,andar
    ,numero
    ,tipo_cama
    ,qtd_cama
    ,qtd_banheiro
    ,banheira
    ,ar_condicionado
    ,servico_quarto
    ,cafe_manha
    ,valor_dia
     FROM quarto WHERE id_quarto = :id_quarto";
    $resultado = $conn->prepare($query);
    $resultado->bindParam(":id_quarto", $id_quarto);
    $resultado->execute();

    $row = $resultado->fetch(PDO::FETCH_ASSOC);
    $retorno["id_quarto"] = $row["id_quarto"];
    $retorno["andar"] = $row["andar"];
    $retorno["numero"] = $row["numero"];
    $retorno["tipo_cama"] = $row["tipo_cama"];
    $retorno["qtd_cama"] = $row["qtd_cama"];
    $retorno["qtd_banheiro"] = $row["qtd_banheiro"];
    $retorno["banheira"] = $row["banheira"];
    $retorno["ar_condicionado"] = $row["ar_condicionado"];
    $retorno["servico_quarto"] = $row["servico_quarto"];
    $retorno["cafe_manha"] = $row["cafe_manha"];
    $retorno["valor_dia"] = $row["valor_dia"];
}else{
    $retorno["id_quarto"] = "";
    $retorno["andar"] = "";
    $retorno["numero"] = "";
    $retorno["tipo_cama"] = "";
    $retorno["qtd_cama"] = "";
    $retorno["qtd_banheiro"] = "";
    $retorno["banheira"] = "";
    $retorno["ar_condicionado"] = "";
    $retorno["servico_quarto"] = "";
    $retorno["cafe_manha"] = "";
    $retorno["valor_dia"] = "";
}
echo json_encode($retorno);