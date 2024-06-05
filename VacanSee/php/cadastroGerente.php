<?php
include_once "conexao.php";
session_start();
//variável booleana que permite o cadastro futuramente
$permite_cadastro = false;
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$senha_md5 = md5($dados['senha']);
$id_hotel = $_SESSION["id_hotel"];

//$isAlterar = $id_hotel > 0 ? true:false;

if($id_hotel <= 0){
//validação de endereço repetido, utilizando o cep + numero como parametros.
    $sql_fk_endereco = "SELECT * FROM endereco WHERE cep = :cep AND numero = :numero ORDER BY id_endereco desc";
    $pega_dados_endereco = $conn->prepare($sql_fk_endereco);
    $pega_dados_endereco->bindParam(':cep', $dados['cep']);
    $pega_dados_endereco->bindParam(':numero', $dados['numero']);
    $pega_dados_endereco->execute();

    //caso nao exista o endereço, ele fará a verificação de usuário repetido.
    $row = $pega_dados_endereco->rowCount();
    if($row == 0){
        //validação de usuario repetido, utilizando o usuario como parametro.
        $sql_fk_usuario = "SELECT * FROM usuario WHERE usuario = :usuario ORDER BY id_usuario desc";
        $pega_dados_usuario = $conn->prepare($sql_fk_usuario);
        $pega_dados_usuario->bindParam(':usuario', $dados['usuario']);
        $pega_dados_usuario->execute();

        //caso nao exista o usuario, ele fará a verificação de cnpj repetido.
        $row = $pega_dados_usuario->rowCount();
        if($row == 0){
            //validação de cnpj repetido, utilizando o cnpj como parametro.
            $sql_cnpj = "SELECT * FROM hotel WHERE (cnpj) = (:cnpj)";
            $pegaDados = $conn->prepare($sql_cnpj);
            $pegaDados->bindParam(':cnpj', $dados['cnpj']);
            $pegaDados->execute();
            if($pegaDados->rowCount() == 1){
                $retorna = "CNPJ ja cadastrado em nosso Banco de Dados";
            }else{
                //caso não exista o cnpj, ele muda a variavel de permissão de cadastro pra true, prosseguindo para os inserts no banco.
                $permite_cadastro = true;
            }
            }else{
            $retorna = "Usuario inserido já existe, favor utilizar outro usuario";
            }
        }else{
            $retorna = "Endereco inserido ja existe, favor utilizar outro endereco";
        }
    }else{
        $permite_cadastro = true;
    }
if($permite_cadastro){
//query de inserção/edição na tabela endereco
    if($id_hotel > 0){
        //buscando ID Endereco  
        $query_id_enredeco = 
        "SELECT id_endereco 
        FROM hotel
        WHERE id_hotel= :id_hotel;
        ";

        $result_id_endereco = $conn->prepare($query_id_enredeco);
        $result_id_endereco->bindParam(':id_hotel', $id_hotel);
        $result_id_endereco->execute();
        $dado_id_loc = $result_id_endereco->fetch(PDO::FETCH_ASSOC);
        $id_end = $dado_id_loc['id_endereco'];


        $query_endereco = 
        "UPDATE endereco 
            SET  
            estado = :estado
            ,cidade = :cidade
            ,bairro = :bairro
            ,cep = :cep
            ,rua = :rua
            ,numero = :numero
            ,complemento = :complemento
            WHERE id_endereco = :id_endereco"; 
        }else{
            $query_endereco ="INSERT INTO endereco ( estado, cidade, bairro, cep, rua, numero, complemento) 
            VALUES (:estado, :cidade, :bairro, :cep, :rua, :numero, :complemento)";
        }


    //bindando os valores do form nas variaveis para utilizar a inserção SQL
    $cad_endereco = $conn->prepare($query_endereco);
    $cad_endereco->bindParam(':estado', $dados['estado']);
    $cad_endereco->bindParam(':cidade', $dados['cidade']);
    $cad_endereco->bindParam(':bairro', $dados['bairro']);
    $cad_endereco->bindParam(':cep', $dados['cep']);
    $cad_endereco->bindParam(':rua', $dados['rua']);
    $cad_endereco->bindParam(':numero', $dados['numero']);
    $cad_endereco->bindParam(':complemento', $dados['complemento']);
    //insere no banco
    if($id_hotel > 0){
        $cad_endereco->bindParam(':id_endereco', $id_end);
        $cad_endereco->execute();
    }else{
        $cad_endereco->execute();
    }

    //processo de consultar a tabela endereço para pegar o id_endereco(FOREIGN KEY) para inserção na tabela hotel futuramente.
    $sql_fk_endereco = "SELECT * FROM endereco WHERE cep = :cep AND numero = :numero ORDER BY id_endereco desc";
    $pega_dados_endereco = $conn->prepare($sql_fk_endereco);
    $pega_dados_endereco->bindParam(':cep', $dados['cep']);
    $pega_dados_endereco->bindParam(':numero', $dados['numero']);
    $pega_dados_endereco->execute();

    $row = $pega_dados_endereco->rowCount();
    $id_endereco = -1;
    if($row == 1){
        $dados_endereco = $pega_dados_endereco->fetch(PDO::FETCH_ASSOC);
        $id_endereco = $dados_endereco['id_endereco'];
    }

    //query de inserção/edição na tabela usuário
    if($id_hotel > 0){
        //buscando ID usuario
        $query_id_usuario = 
        "SELECT id_usuario
        FROM hotel
        WHERE id_hotel = :id_hotel;
        ";
        $result_id_usuario = $conn->prepare($query_id_usuario);
        $result_id_usuario->bindParam(':id_hotel', $id_hotel);
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
    if($id_hotel > 0){
        $cad_usuario->bindParam(':id_usuario', $id_user);
        $cad_usuario->execute();
    }else{
        $cad_usuario->execute();
    }

    //processo de consultar a tabela endereço para pegar o id_usuario(FOREIGN KEY) para inserção na tabela hotel futuramente.
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

     //query de inserção/edição na tabela hotel
    
    if($id_hotel > 0){
        $query_hotel = 
         "UPDATE hotel 
        SET  
         cnpj = :cnpj
        ,telefone = :telefone
        WHERE id_hotel = :id_hotel"; 
    }else{
    $query_hotel = 
    "INSERT INTO hotel (
        cnpj
        , telefone
        , id_endereco
        , id_usuario
        ) 
        VALUES (
              :cnpj
            , :telefone
            , :id_endereco
            , :id_usuario
            )";
    }

    //bindando os valores do form nas variaveis para utilizar a inserção SQL
    $cad_hotel = $conn->prepare($query_hotel);
    $cad_hotel->bindParam(':cnpj', $dados['cnpj']);
    $cad_hotel->bindParam(':telefone', $dados['telefone']);
    //guardando as foreign keys das variaveis nos parametros
    //insere no banco
    if($id_hotel > 0){
        $cad_hotel->bindParam(':id_hotel', $id_hotel);
        $cad_hotel->execute();
    }else{
        //guardando as foreign keys das variaveis nos parametros
        $cad_hotel->bindParam(':id_usuario', $id_usuario);
        $cad_hotel->bindParam(':id_endereco', $id_endereco);
        $cad_hotel->execute();
    }

    //caso insira com sucesso, retornará a mensagem validando.
    
    if($id_hotel <= 0){
        if($cad_hotel->rowCount() == 1){
            $retorna = "Usuario cadastrado com sucesso";
        }else{
            $retorna = "Nao foi possivel cadastrar o usuario, verificar os campos";
        }  
    }else{
        $retorna = "Usuario atualizado com sucesso";
    }
}
echo json_encode($retorna);