<?php
include_once "conexao.php";
session_start();
//variável booleana que permite o cadastro futuramente
$permite_cadastro = false;
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$senha_md5 = md5($dados['senha']);
$id_hospede = $_SESSION["id_hospede"];
echo($id_hospede);

//$isAlterar = $id_hospede > 0 ? true:false;

if($id_hospede <= 0){
    //validação de usuario repetido, utilizando o usuario como parametro.
    $sql_fk_usuario = "SELECT * FROM usuario WHERE usuario = :usuario ORDER BY id_usuario desc";
    $pega_dados_usuario = $conn->prepare($sql_fk_usuario);
    $pega_dados_usuario->bindParam(':usuario', $dados['usuario']);
    $pega_dados_usuario->execute();

    //caso nao exista o usuario, ele fará a verificação de CPF repetido.
    $row = $pega_dados_usuario->rowCount();
    if($row == 0){
        //validação de cpf repetido, utilizando o cpf como parametro.
        $sql_cpf = "SELECT * FROM hospede WHERE (cpf) = (:cpf)";
        $pegaDados = $conn->prepare($sql_cpf);
        $pegaDados->bindParam(':cpf', $dados['cpf']);
        $pegaDados->execute();
        if($pegaDados->rowCount() == 1){
            $retorna = "CPF já cadastrado em nosso Banco de Dados!";
        }else{
            //caso não exista o cpf, ele muda a variavel de permissão de cadastro pra true, prosseguindo para os inserts no banco.
            $permite_cadastro = true;
        }
        }else{
        $retorna = "Usuario inserido ja existe, favor utilizar outro usuario.";
        }
}else{
    $permite_cadastro = true;
}


if($permite_cadastro){
//query de inserção/edição na tabela usuário
    if($id_hospede > 0){
        //buscando ID usuario
        $query_id_usuario = 
        "SELECT id_usuario
        FROM hospede
        WHERE id_hospede = :id_hospede;
        ";
        $result_id_usuario = $conn->prepare($query_id_usuario);
        $result_id_usuario->bindParam(':id_hospede', $id_hospede);
        $result_id_usuario->execute();
        $dado_id_user = $result_id_usuario->fetch(PDO::FETCH_ASSOC);
        $id_user = $dado_id_user['id_usuario'];

        $query_usuario = 
        "UPDATE usuario 
            SET  
            nome = :nome
            ,email = :email
            ,usuario = :usuario
            ,senha = :senha
            ,flag_bloqueado = :flag_bloqueado
            WHERE id_usuario = :id_usuario"; 
    }else{
        $query_usuario = "INSERT INTO usuario (nome, email, usuario, senha, flag_bloqueado) 
                            VALUES (:nome, :email, :usuario, :senha, :flag_bloqueado)";
        $flag_bloqueado = "N";
    }

    //bindando os valores do form nas variaveis para utilizar a inserção SQL
    $cad_usuario = $conn->prepare($query_usuario);
    $cad_usuario->bindParam(':nome', $dados['nome']);
    $cad_usuario->bindParam(':email', $dados['email']);
    $cad_usuario->bindParam(':usuario', $dados['usuario']);
    $cad_usuario->bindParam(':senha', $senha_md5);
    $cad_usuario->bindParam(':flag_bloqueado', $flag_bloqueado);
    //insere no banco
    if($id_hospede > 0){
        $cad_usuario->bindParam(':id_usuario', $id_user);
        $cad_usuario->execute();
    }else{
        $cad_usuario->execute();
    }

    //processo de consultar a tabela endereço para pegar o id_usuario(FOREIGN KEY) para inserção na tabela hospede futuramente.
    $sql_fk_usuario = "SELECT * FROM usuario WHERE usuario = :usuario ORDER BY id_usuario desc";
    $pega_dados_usuario = $conn->prepare($sql_fk_usuario);
    $pega_dados_usuario->bindParam(':usuario', $dados['usuario']);
    $pega_dados_usuario->execute();

    $row = $pega_dados_usuario->rowCount();
    $id_usuario = -1;
    if($row == 1){
        $dados_usuario = $pega_dados_usuario->fetch(PDO::FETCH_ASSOC);
        $id_usuario = $dados_usuario['id_usuario'];
    }

        //query de inserção/edição na tabela hospede

    if($id_hospede > 0){
        $query_hospede = 
            "UPDATE hospede 
        SET  
            cpf = :cpf
        ,celular = :celular
        ,data_nascimento = :data_nascimento
        WHERE id_hospede = :id_hospede"; 
    }else{
    $query_hospede = 
    "INSERT INTO hospede (
        cpf
        , celular
        , data_nascimento
        , id_usuario
        ) 
        VALUES (
                :cpf
            , :celular
            , :data_nascimento
            , :id_usuario
            )";
    }

    //bindando os valores do form nas variaveis para utilizar a inserção SQL
    $cad_hospede = $conn->prepare($query_hospede);
    $cad_hospede->bindParam(':cpf', $dados['cpf']);
    $cad_hospede->bindParam(':celular', $dados['celular']);
    $cad_hospede->bindParam(':data_nascimento', $dados['data_nascimento']);
    //guardando as foreign keys das variaveis nos parametros
    //insere no banco
    if($id_hospede > 0){
        $cad_hospede->bindParam(':id_hospede', $id_hospede);
        $cad_hospede->execute();
    }else{
        //guardando as foreign keys das variaveis nos parametros
        $cad_hospede->bindParam(':id_usuario', $id_usuario);
        $cad_hospede->execute();
    }

    //caso insira com sucesso, retornará a mensagem validando.

    if($id_hospede <= 0){
        if($cad_hospede->rowCount() == 1){
            $retorna = "Usuario cadastrado com sucesso!";
        }else{
            $retorna = "Nao foi possivel cadastrar o usuario, verificar os campos.";
        }  
    }else{
        $retorna = "hospede atualizado com sucesso!";
    }
}
echo json_encode($retorna);