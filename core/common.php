<?php


function dump(...$values)
{
    $style = <<<STYLE
        border:1px solid #ccc;
        border-radius: 5px;
        background-color: lightcyan;
        padding:8px; 
    STYLE;
    if (!empty($values))
        foreach ($values as $v) {
            ob_start();
            var_dump($v);
            printf('<pre style="%s">%s</pre>', $style, ob_get_clean());
        }
}

function dd(...$values)
{
    $style = <<<STYLE
        border:1px solid #ccc;
        border-radius: 5px;
        background-color: lightcyan;
        padding:8px; 
    STYLE;
    if (!empty($values))
        foreach ($values as $v) {
            printf('<pre style="%s">%s</pre>', $style, print_r($v, true));
        }
}