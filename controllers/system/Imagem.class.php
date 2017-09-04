<?php

use Intervention\Image\ImageManager;

class Imagem{

//    private $Retorno;
//    private $Dados;
//
//    public function Retorno(array $dados){
//
//        $this->Dados = $dados["DADOS"] ?? NULL;
//        $this->{$dados["METODO"]}();
//
//        return $this->Retorno;
//    }

    static public function putimagem(array $dados)
    {
        $img = new ImageManager();
        $Inserir = new Inserir();

        $sizes = ['x480' => 480, 'x640' => 640, 'x760' => 760, 'x1024' => 1024, 'x1280' => 1280, 'x1440' => 1440, 'x1920' => 1920, 'x2048' => 2048, 'x2160' => 2160];
        $Dados = [];

        for ($a = 0; $a < count($sizes); $a++):
            for($b=0; $b < count($dados[1]['arquivos']['tmp_name']); $b++):
                $Dados[$b][array_keys($dados[0])[0]] = array_values($dados[0])[0];
                $Dados[$b]['original'] = $img->make($dados[1]['arquivos']['tmp_name'][$b])->encode('data-url');
                $Dados[$b][array_keys($sizes)[$a]] = $img->make($dados[1]['arquivos']['tmp_name'][$b])->encode('jpg', 85)->widen(array_values($sizes)[$a])->encode('data-url');
            endfor;
        endfor;

        if(count($Dados) == 1):
            $Inserir->exeInserir("img_interacao", $Dados[0]);
        else:
            for($c=0;$c < count($Dados);$c++):
                $Inserir->exeInserir("img_interacao", $Dados[$c]);
            endfor;
        endif;
    }

    static public function directXperRequest($resolution)
    {
        $return = NULL;

        switch(true):
            case (intval($resolution) <= 480) : $return = 'x480'; break;
            case (intval($resolution) >= 481 && intval($resolution) <= 640) : $return = 'x640'; break;
            case (intval($resolution) >= 641 && intval($resolution) <= 760) : $return = 'x760'; break;
            case (intval($resolution) >= 761 && intval($resolution) <= 1024) : $return = 'x1024'; break;
            case (intval($resolution) >= 1025 && intval($resolution) <= 1280) : $return = 'x1280'; break;
            case (intval($resolution) >= 1281 && intval($resolution) <= 1440) : $return = 'x1440'; break;
            case (intval($resolution) >= 1441 && intval($resolution) <= 1920) : $return = 'x1920'; break;
            case (intval($resolution) >= 1921 && intval($resolution) <= 2048) : $return = 'x2048'; break;
            case (intval($resolution) >= 2049 && intval($resolution) <= 2160) : $return = 'x2160'; break;
        endswitch;

        return $return;
    }
}