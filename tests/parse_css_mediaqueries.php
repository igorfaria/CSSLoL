<?php

header('Content-type: text/plain;charset=utf8;');

require '../CSSLoL.class.php';

$CSSLoL = new CSSLoL();

$CSS1 = <<<CSS1
    html, body{
        margin: 0;
        padding: 0px;
    }
    @media all and (max-width: 767px) and (min-width: 0) {
        body {padding: 10px;}
        div.animated{animation:none}
    }
    img {max-width: 100%}
    @media print {
        body {
            background: white;
        }
    }
CSS1;

$CSSLoL->set($CSS1);

var_dump($CSSLoL->get());