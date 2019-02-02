<?php

header('Content-type: text/plain;charset=utf8;');

require '../CSSLoL.class.php';

$CSSLoL = new CSSLoL();

$CSS1 = <<<CSS1
    html, body{
        margin: 0;
        padding: 0px;
    }
    div.animated{animation: example linear 0.3s;} 
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
    @keyframes example {
        from {background-color: red;}
        to {background-color: yellow;}
      }
    @keyframes example2 {
        0%   {background-color: red;}
        25%  {background-color: yellow;}
        50%  {background-color: blue;}
        100% {background-color: green;}
      } 
      
CSS1;

$CSSLoL->set($CSS1);

var_dump($CSSLoL->get());