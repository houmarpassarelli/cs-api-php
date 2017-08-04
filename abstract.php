<?php

class callUsuario
{

    private $Output;

    public function __construct(array $dados)
    {
        $this->Output = (new Usuario())->Retorno($dados);
        $this->Resultado();
    }

    public function Resultado()
    {
        return $this->Output;
    }
}

class callParceiro{

    private $Output;

    public function __construct(array $dados)
    {
        $this->Output = (new Parceiro())->Retorno($dados);
        $this->Resultado();
    }

    public function Resultado(){
        return $this->Output;
    }
}

class callCupom{

    private $Output;

    public function __construct(array $dados)
    {
        $this->Output = (new Cupom())->Retorno($dados);
        $this->Resultado();
    }

    public function Resultado(){
        return $this->Output;
    }
}

class callLogin{

    private $Output;

    public function __construct(array $dados)
    {
        $this->Output = (new Login())->Retorno($dados);
        $this->Resultado();
    }

    public function Resultado(){
        return $this->Output;
    }
}

class callPacote{

    private $Output;

    public function __construct(array $dados)
    {
        $this->Output = (new Pacote())->Retorno($dados);
        $this->Resultado();
    }

    public function Resultado(){
        return $this->Output;
    }
}

class callContato{
    private $Output;

    public function __construct(array $dados)
    {
        $this->Output = (new Contato())->Retorno($dados);
        $this->Resultado();
    }

    public function Resultado(){
        return $this->Output;
    }
}

class callImagem{
    private $Output;

    public function __construct(array $dados)
    {
        $this->Output = (new Imagem())->Retorno($dados);
    }

    public function Resultado(){
        return $this->Output;
    }
}