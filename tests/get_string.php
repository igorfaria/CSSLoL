<?php

header('Content-type: text/plain;charset=utf8;');

require '../CSSLoL.class.php';

$CSSLoL = new CSSLoL();
$CSSLoL->load('css/css2.min.css');

echo 'Indented' . PHP_EOL. PHP_EOL;
echo $CSSLoL->get('string',false);

echo PHP_EOL. PHP_EOL;

echo 'Minified' . PHP_EOL. PHP_EOL;
echo($CSSLoL->get('string',true));