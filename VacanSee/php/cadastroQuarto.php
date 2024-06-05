<?php
include_once "conexao.php";
session_start();
$id_quarto = $_SESSION["id_quarto"];
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if($id_quarto > 0){
    $query_quarto = 
    "UPDATE quarto 
        SET andar = :andar
            ,numero = :numero
            ,tipo_cama = :tipo_cama
            ,qtd_cama = :qtd_cama
            ,qtd_banheiro = :qtd_banheiro
            ,banheira = :banheira
            ,ar_condicionado = :ar_condicionado
            ,servico_quarto = :servico_quarto
            ,cafe_manha = :cafe_manha
            ,valor_dia = :valor_dia
        WHERE id_quarto = :id_quarto"; 
}else{
$query_quarto = 
    "INSERT
        INTO quarto(
             andar
            ,numero
            ,tipo_cama
            ,qtd_cama
            ,qtd_banheiro
            ,banheira
            ,ar_condicionado
            ,servico_quarto
            ,cafe_manha
            ,valor_dia
            ,flag_reservado
            ,id_hotel
            ) 
        VALUES (
        :andar
        ,:numero
        ,:tipo_cama
        ,:qtd_cama
        ,:qtd_banheiro
        ,:banheira
        ,:ar_condicionado
        ,:servico_quarto
        ,:cafe_manha
        ,:valor_dia
        ,'N'
        ,:id_hotel
        )";
}

$cad_quarto = $conn->prepare($query_quarto);
$cad_quarto->bindParam(':andar', $dados['andar']);
$cad_quarto->bindParam(':numero', $dados['numero']);
$cad_quarto->bindParam(':tipo_cama', $dados['tipo_cama']);
$cad_quarto->bindParam(':qtd_cama', $dados['qtd_cama']);
$cad_quarto->bindParam(':qtd_banheiro', $dados['qtd_banheiro']);
$cad_quarto->bindParam(':banheira', $dados['banheira']);
$cad_quarto->bindParam(':ar_condicionado', $dados['ar_condicionado']);
$cad_quarto->bindParam(':servico_quarto', $dados['servico_quarto']);
$cad_quarto->bindParam(':cafe_manha', $dados['cafe_manha']);
$cad_quarto->bindParam(':valor_dia', $dados['valor_dia']);
$cad_quarto->bindParam(':id_hotel', $_SESSION['id_hotel']);


if($id_quarto > 0){
    $cad_quarto->bindParam(':id_quarto', $id_quarto);
    $cad_quarto->execute();
    $retorna = "Quarto atualizado com sucesso!";
}else{
    $cad_quarto->execute();
    if($cad_quarto->rowCount() == 1){
        $retorna = "Quarto cadastrado com sucesso!";
    }else{
        $retorna = "Nao foi possivel cadastrar o Quarto, verificar os campos";
    }
}
echo json_encode($retorna);