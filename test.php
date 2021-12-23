<?php

use HL\FPS\EMV;
use HL\FPS\Generator;

require_once("vendor/autoload.php");

$obj = new EMV();
$obj->mcc = "0000";
$obj->account = "02";
$obj->fps_id = "100552215";
$obj->currency = "344";
$obj->amount = "100";


$gen = new Generator();
echo $gen->generate($obj);
