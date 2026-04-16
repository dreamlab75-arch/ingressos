<?php

namespace Felipebastosvitt\Ingressos\Model;
use DateTime;

class Ingresso{
    private int $id;
    private DateTime $sessao;
    private Filme $filme;
    private string $sala;
    private string $nomeCliente;
    private float $preco;
    
}
?>