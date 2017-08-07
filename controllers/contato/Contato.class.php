<?php
class Contato
{
    private $Dados;
    private $ID;
    private $Retorno;

    public function Retorno(array $dados){

        $this->Dados = $dados["DADOS"] ?? NULL;
        $this->ID = $dados["ID"] ?? NULL;
        $this->{$dados["METODO"]}();

        return $this->Retorno;
    }

    private function putcontato(){

        $Dados = [
            "id_usuario" => $this->Dados["id"],
            "id_contato" => $this->Dados["usuario"]
        ];

        $Inserir = new Inserir();
        $Inserir->exeInserir("usuario_contato", $Dados);

        if($Inserir->Resultado()):
            $this->Retorno = json_encode(['codigo' =>'200']);
        else:
            $this->Retorno = json_encode(['codigo' =>'100']);;
        endif;

    }

    private function getcontato(){

        if(!is_null($this->ID)):

            $Exibir = new Exibir();
            $Exibir->exeExibir("SELECT
                                        u.codigo,
                                        u.nome,
                                        u.sobrenome,
                                        u.avatar,
                                        u.email
                                        FROM usuario_contato C
                                        LEFT JOIN usuario u ON u.id_usuario = c.id_contato
                                        WHERE c.id_usuario = (SELECT id_usuario FROM usuario WHERE codigo = :codigo)", NULL, NULL, "codigo={$this->ID}", FALSE);

            $this->Retorno = json_encode($Exibir->Resultado());
        endif;
    }

    private function searchcontato(){

        $Exibir = new Exibir();
        $Exibir->exeExibir("SELECT 
                                    u.codigo AS id,
                                    u.avatar,
                                    u.nome,
                                    u.sobrenome,
                                    u.email
                                    FROM usuario u
                                    WHERE (u.nome LIKE '%{$this->Dados['contactsearch']}%' OR u.email LIKE '%{$this->Dados['contactsearch']}%') AND u.visivel = 'S'");

        if($Exibir->Resultado()):
            $this->Retorno = json_encode($Exibir->Resultado());
        else:
            $this->Retorno = json_encode(["codigo" => "0401"]);
        endif;
    }

    private function deletecontato(){

    }
}