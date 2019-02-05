<?php

header('Content-type: text/plain;charset=utf8;');

require '../CSSLoL.class.php';

$CSSLoL = new CSSLoL();
$CSSLoL->load('css/long_css.css');


echo(strlen($CSSLoL->get('string',false)) . ' chars idented' . PHP_EOL);

echo(strlen($CSSLoL->get('string')) . ' chars minified');