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

    private function putimagem()
    {

        $img = new ImageManager();
        $Inserir = new Inserir();

        $sizes = ['x480' => 480, 'x640' => 640, 'x760' => 760, 'x1024' => 1024, 'x1280' => 1280, 'x1440' => 1440, 'x1920' => 1920, 'x2048' => 2048, 'x2160' => 2160];
        $Dados = [];

        for ($a = 0; $a < count($sizes); $a++):
            for($b=0; $b < count($this->Dados['arquivos']['tmp_name']); $b++):
                $Dados[$b]['original'] = $img->make($this->Dados['arquivos']['tmp_name'][$b])->encode('data-url');
                $Dados[$b][array_keys($sizes)[$a]] = $img->make($this->Dados['arquivos']['tmp_name'][$b])->encode('jpg', 85)->widen(array_values($sizes)[$a])->encode('data-url');
            endfor;
        endfor;

        if(count($Dados) == 1):
            $Inserir->exeInserir("img_interacao", $Dados);
        else:
            for($c=0;$c < count($Dados);$c++):
                $Inserir->exeInserir("img_interacao", $Dados[$c]);
            endfor;
        endif;

        $this->Retorno = count($Dados);

    }

    private function getimagemperXnID()
    {
        $Exibir = new Exibir();

        $Exibir->exeExibir("SELECT x480 FROM img_interacao", NULL, NULL, NULL, FALSE);

        $this->Retorno = json_encode($Exibir->Resultado()[0]);

    }

}