<?php
function debug($variable)
{
    echo '<pre>' .print_r($variable, true). '</pre>';
}
 function Tokken_Validation($length){
    $Lettrine = "COOL";
    $combi = "01234567890";
    return substr($Lettrine.str_shuffle(str_repeat($combi, $length)),0,$length);
 }