<?php
//Conexão com o banco de dados
$host = "localhost";
$db = "filmes";
$user = "root";
$pass = "";

//try/catch para tratar erros de conexão

try{
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOexception $e){
    echo json_encode(["erro" => $e->getMessage()]);
    exit;
}

function cadastrarFilmes($pdo){
    // recebe json enviado pelo front-end
    $dados = json_decode(file_get_contents("php://input"), true);

    //validação simples
    if (
        empty($dados["imdb"]) ||
        empty($dados["titulo"]) ||
        empty($dados["genero"]) ||
        empty($dados["duracao"]) ||
        empty($dados["classificacao"])
    ) {
        echo json_encode(["erro" => "Dados incompletos"]);
        return;
    }

    $sql = "INSERT INTO filmes (imdb, titulo, genero, duracao, classificacao) VALUES (:imdb, :titulo, :genero, :duracao, :classificacao)";
    //comando do insert para o banco

    $stmt = $pdo->prepare($sql);
    //prepara o banco para receber o insert into
    $stmt->bindValue(":imdb", $dados["imdb"]);
    $stmt->bindValue(":titulo", $dados["titulo"]);
    //verifica quais valores vao ser mandados pro banco com base no html
    $stmt->bindValue(":genero", $dados["genero"]);
    $stmt->bindValue(":duracao", $dados["duracao"]);
    $stmt->bindValue(":classificacao", $dados["classificacao"]);

    $stmt->execute();
    //executa o comando

    echo json_encode(["message" => "Filme cadastrado com sucesso!"]);
    //msg de sucesso
}

function deletarFilme($pdo){
    $dados = json_decode(file_get_contents("php://input"), true);

    if(empty($dados["imdb"])){
        echo json_encode(["erro" => "Imdb do filme é obrigatório"]);
        return;
    }

    $sql = "DELETE FROM filmes WHERE imdb = :imdb";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":imdb", $dados["imdb"]);

    $stmt->execute();

    echo json_encode(["message" => "Filme deletado com sucesso!"]);
}

function atualizarFilme($pdo){

    $dados = json_decode(file_get_contents("php://input"), true);

    if (

        empty($dados["imdb"]) ||
        empty($dados["titulo"]) ||
        empty($dados["genero"]) ||
        empty($dados["duracao"]) ||
        empty($dados["classificacao"])
    ) {

        echo json_encode(["erro" => "Dados incompletos"]);
        return;
    }

    $sql = "UPDATE filmes SET titulo = :titulo, genero = :genero, duracao = :duracao, classificacao = :classificacao WHERE imdb = :imdb";

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(":imdb", $dados["imdb"]);
    $stmt->bindValue(":titulo", $dados["titulo"]);
    $stmt->bindValue(":genero", $dados["genero"]);
    $stmt->bindValue(":duracao", $dados["duracao"]);
    $stmt->bindValue(":classificacao", $dados["classificacao"]);

    $stmt->execute();

    echo json_encode(["message" => "Filme atualizado com sucesso!"]);

}


