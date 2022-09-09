<?php

function MakeArray ($quantity){
    $numbers = array();
    for ($i = 0; $i <= $quantity; $i++) {
        $numbers[] = $i;
    }
    shuffle($numbers);
    return $numbers;   
}

function MakeStartArray ($quantity){
    $stars = array();
    for ($i = 0; $i <= $quantity; $i++) {
        $stars[] = "*";
    }
    return $stars;   
}

function ShowCollection ($collection){
    $list = "<ul>";
    foreach ($collection as $key => $value) {
        $list .= "<li> $key : $value </li>";
    }
    $list .= "</ul>";
    return $list;
}