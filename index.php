<?php

require "vendor/autoload.php";

use Felipebastosvitt\Ingressos\Controller\FilmeController;

use Felipebastosvitt\Ingressos\Model\Filme;

use Felipebastosvitt\Ingressos\Utils\Validation;

header("Content-Type: application/json; charset=UTF-8");

$metodo = $_SERVER["REQUEST_METHOD"];//qual foi o método HTTP utilizado para acessar a rota
$controller = new FilmeController();
$validation = new Validation();


switch($metodo){
    case "GET": //lista o recurso


    $data = $controller->listarFilmes();

    http_response_code(200);

    echo json_encode(["status"=>"success", "data"=>$data
    ], JSON_PRETTY_PRINT
);
        break;
    case "POST": //cadastra novo recurso
        
        $filme_um = new Filme(imdb: "tt28650488", titulo: "Super Mario Galaxy: O Filme", genero: array("Animação", "Aventura"), duracao: 98, classificacao: "Livre");

        $data = $validation-> validator(
        [
            "imdb" => $filme_um->imdb,
            "titulo" => $filme_um->titulo,
            "genero" => $filme_um->genero,
            "duracao" => $filme_um->duracao,
            "classificacao" => $filme_um->classificacao
        ], //dados

        [
            "imdb" => "required|size:10", //required = not null, size:10 = tem que ter 10 caracteres
            "titulo" => "required|min:5", 
            "genero" => "required|array|min:1", //required = not null, array = tem que ser um array, min:1 = tem que ter pelo menos 1 item
            "duracao" => "required|numeric|min:90",
            "classificacao" => "required|min:2"
        ], //regras
        [
        "imdb.required" => "O campo imdb é obrigatório.",
        "titulo.required" => "O campo titulo é obrigatório.",
        "genero.required" => "O campo genero é obrigatório.",
        "genero.array" => "O campo genero deve ser um array.",
         "genero.min" => "O campo genero deve ter pelo menos 1 item.",
         "duracao.required" => "O campo duracao é obrigatório.",
         "duracao.integer" => "O campo duracao deve ser um número inteiro.",
         "classificacao.required" => "O campo classificacao é obrigatório.",
         "classificacao.string" => "O campo classificacao deve ser uma string."
        ], //mensagens de validação

    );

    if($validation->fails()){
        echo json_encode(["success"=>false,"message"=>errors()->all()]);
        http_response_code(400);
        exit;
    }

    $controller->cadastrar($filme_um);
        
    http_response_code(201);

    echo json_encode(["success"=>true,"message"=>"Filme cadastrado com sucesso!"]);// tornar em formato json, fazer o array associativo, e mostrar a mensagem de sucesso ou erro, dependendo do resultado da validação

        break;
    case "PUT": //editar o recurso
        
        $filme_atualizado = new Filme(imdb: "tt28650488", titulo: "Super Mario Galaxy: O Filme", genero: array("Animação", "Aventura"), duracao: 98, classificacao: 10);
        
        $controller->atualizarFilme("tt28650488", $filme_atualizado);
        
        http_response_code(200);
        
        echo json_encode(["status"=>"success", "message"=>"Filme atualizado com sucesso!!!"]);
        
        break;
    case "DELETE": //deletar o recurso
        
        $imdb = $_REQUEST["imdb"];
        
        $filme = $controller->buscarFilme($imdb); //se exister ai tenta deletar, se nao nem tenta buscar
        
        if(is_null($filme)){
        
            http_response_code(404);
        
            die; //mata o processo nao saindo do if
        
        }
        
        $controller->deletarFilme($imdb); // se nao entrar no if, deletar, da o http e mensagem de sucesso
        
        http_response_code(200);
        
        echo json_encode(["status"=>"success", "message"=>"Filme removido com sucesso!!!"]);
        
        break;
    default:
        
    http_response_code(405);
    
    break;
     

}

?>