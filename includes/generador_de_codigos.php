<?php
    function generar_codigo($j){
        $array = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
        $clave = "";
        for($i = 0; $i < $j; $i++){
            $clave .= $array[rand(0, count($array) - 1)];
        }
        return $clave;
    }