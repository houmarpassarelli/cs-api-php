<?php

use Intervention\Image\ImageManager;

class Imagem{

    private $Retorno;
    private $Dados;

    public function Retorno(array $dados){

        $this->Dados = $dados["DADOS"] ?? NULL;
        $this->{$dados["METODO"]}();

        return $this->Retorno;
    }

    private function putimagem(){

        $img = new ImageManager();
        $sizes = ['x480' => 480, 'x640' => 640, 'x760' => 760, 'x1024' => 1024, 'x1280' => 1280, 'x1440' => 1440, 'x1920' => 1920, 'x2048' => 2048, 'x2160' => 2160];
        //$keys = array_keys($sizes);
        $convert = [];

        for($a=0; $a < count($sizes); $a++):
            //$convert[array_keys($sizes)[$a]] = array_values($sizes)[$a];
            $convert[array_keys($sizes)[$a]] = $img->make('./teste2.jpg')->encode('jpg', 85)->widen(array_values($sizes)[$a])->encode('data-url');
        endfor;

        //exit(print_r($convert));

        $this->Retorno = json_encode($convert);

//        $x480 = $img->make()->encode('jpg', 85)->widen(480)->encode('data-url');
//        $x640 = $img->make()->encode('jpg', 85)->widen(640)->encode('data-url');
//        $x760 = $img->make()->encode('jpg', 85)->widen(760)->encode('data-url');

    }

}