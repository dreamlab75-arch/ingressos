<?php

namespace Felipebastosvitt\Ingressos\Model;

class Filme{
    private string $imdb;
    private string $titulo;
    private array $genero;
    private int $duracao; //Minutos
    private int|string $classificacao;

    public function __construct(string $imdb, string $titulo, array $genero, int $duracao, int|string $classificacao)
    {
        $this->imdb = $imdb;
        $this->titulo = $titulo;
        $this->genero = $genero;
        $this->duracao = $duracao;
        $this->classificacao = $classificacao;
    }

    public function __get(string $atributo){
        //echo "Chamou o get do $atributo";
        return $this->$atributo;
    }

    public function __set(string $atributo, mixed $valor){
        //echo "Chamou o set do $atributo";
        $this->$atributo = $valor;
    }
}
?>