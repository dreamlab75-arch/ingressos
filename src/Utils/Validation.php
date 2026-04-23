<?php

namespace Felipebastosvitt\Ingressos\Utils;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;

class Validation{
    private $fileloader;

    private $translaotr;

    private $factory;

    public function __construct(){
        $this->fileloader = new Fileloader(new Filesystem(), "");
        $this->translator = new Translator($this->fileloader, "");
        $this->factory = new Factory($this->translator);


    }

    public function validator(array $data, array $rules, array $messages): Validator{
        return $this->factory->make($data, $rules, $messages);
    }
}