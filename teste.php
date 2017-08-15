<?php
/**
 * @filesource   example.php
 * @created      10.12.2015
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2015 Smiley
 * @license      MIT
 */

//require_once '../vendor/autoload.php';

require('config.inc.php');
//
//use chillerlan\QRCode\Output\QRImage;
//use chillerlan\QRCode\Output\QRImageOptions;
//use chillerlan\QRCode\QRCode;
//
//$qrImageOptions = new QRImageOptions;
//$qrImageOptions->pixelSize = 8;
//$qrImageOptions->base64 = true;
////$qrImageOptions->cachefile = 'example_image.png';
//
////$teste = new QRCode('teste', new QRImage($qrImageOptions));
////var_dump($teste->output());
////echo '<img src="'.(new QRCode('teste', new QRImage($qrImageOptions)))->output().'" />';
//
//$Exibir = new Exibir();
//$Exibir->exeExibir(NULL, "oferta_interacao", NULL, NULL, FALSE);
//
//
//
////$Alterar = new Alterar();
//
//for($i=0; $i < count($Exibir->Resultado()); $i++){
//
//    //$base64 = (new QRCode($Exibir->Resultado()[$i]["hash"].$Exibir->Resultado()[$i]["altcode"], new QRImage($qrImageOptions)))->output();
//
//    //$Alterar->ExeAlterar(NULL, "oferta_interacao", ["qrcode" => $base64] , "WHERE id_oferta_interacao = :id", "id={$Exibir->Resultado()[$i]['id_oferta_interacao']}");
//
//    echo '<img src="'.$Exibir->Resultado()[$i]["qrcode"].'" />';
//}


$array = [];


$Pacote = new Exibir();
$Pacote->exeExibir(NULL, "pacote", NULL,NULL, FALSE);

$Exibir = new Exibir();
for($i=0; $i < count($Pacote->Resultado()); $i++):

    $Exibir->exeExibir("SELECT                                    
                                o.codigo,
                                o.titulo AS titulo_cupom,
                                o.img AS img_cupom,
                                o.descricao,
                                o.regulamento,
                                o.dias_uso,
                                o.min_pessoas,
                                o.max_pessoas,
                                p.id_pacote AS pacote,
                                p.titulo AS titulo_pacote,                                    
                                e.titulo AS titulo_parceiro,
                                e.logo AS img_parceiro
                                FROM oferta o
                                LEFT JOIN estabelecimento e ON e.id_estabelecimento = o.id_estabelecimento
                                LEFT JOIN pacote p ON p.id_pacote = {$Pacote->Resultado()[$i]["id_pacote"]} LIMIT 10", NULL, NULL, NULL , FALSE);



$array[$Pacote->Resultado()[$i]["id_pacote"]] = $Exibir->Resultado();

endfor;

echo '<pre>';
print_r($array);
echo '</pre>';