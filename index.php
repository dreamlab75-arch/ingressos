<?php

require "vendor/autoload.php";

use Felipebastosvitt\Ingressos\Controller\FilmeController;

use Felipebastosvitt\Ingressos\Model\Filme;

header("Content-Type: application/json; charset=UTF-8");

$metodo = $_SERVER["REQUEST_METHOD"];//qual foi o método HTTP utilizado para acessar a rota
$controller = new FilmeController();

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
        $controller->cadastrar($filme_um);
        http_response_code(201);
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