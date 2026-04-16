<?php

namespace Felipebastosvitt\Ingressos\Controller;

use Felipebastosvitt\Ingressos\Model\Filme;


class FilmeController{

    private array $filmes;
    public function __construct(private ?Filme $filme = null){
        $this->filmes = array();
        if(!is_null($filme)){
            $this->cadastrar($filme);
        }
    }

    //Buscar todos os filmes
    public function listarFilmes(): array{
        return $this->filmes;
        }

    public function buscarFilme(string $imdb): ?Filme
    {

        return $this->filmes[$imdb] ?? null;
    }

    public function atualizarFilme(string $imdb, Filme $filme): void{
        $this->filmes[$imdb] = $filme;
    }

    public function deleteFilme(string $imdb){
        unset($this->filmes[$imdb]);
    }

    public function cadastrar(Filme $filme){
        return $this->filmes[$filme->imdb] = $filme;
    }

    }

?>