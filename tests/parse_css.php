<?php

header('Content-type: text/plain;charset=utf8;');

require '../CSSLoL.class.php';

$CSSLoL = new CSSLoL();

$CSS1 = <<<CSS1
    *,*:after,*:before {
        box-sizing: border-box;
    }
    html, body{
        margin: 0;
        padding: 0px;
    }
    div.animated {
        animation: pulse 5s infinite 
    }
    img {max-width: 100%}
CSS1;

$CSSLoL->set($CSS1);

var_dump($CSSLoL->get());