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

use chillerlan\QRCode\Output\QRImage;
use chillerlan\QRCode\Output\QRImageOptions;
use chillerlan\QRCode\QRCode;

$qrImageOptions = new QRImageOptions;
$qrImageOptions->pixelSize = 8;
$qrImageOptions->base64 = true;
//$qrImageOptions->cachefile = 'example_image.png';

//$teste = new QRCode('teste', new QRImage($qrImageOptions));
//var_dump($teste->output());
//echo '<img src="'.(new QRCode('teste', new QRImage($qrImageOptions)))->output().'" />';

$Exibir = new Exibir();
$Exibir->exeExibir(NULL, "oferta_interacao", NULL, NULL, FALSE);



//$Alterar = new Alterar();

for($i=0; $i < count($Exibir->Resultado()); $i++){

    //$base64 = (new QRCode($Exibir->Resultado()[$i]["hash"].$Exibir->Resultado()[$i]["altcode"], new QRImage($qrImageOptions)))->output();

    //$Alterar->ExeAlterar(NULL, "oferta_interacao", ["qrcode" => $base64] , "WHERE id_oferta_interacao = :id", "id={$Exibir->Resultado()[$i]['id_oferta_interacao']}");

    echo '<img src="'.$Exibir->Resultado()[$i]["qrcode"].'" />';
}

