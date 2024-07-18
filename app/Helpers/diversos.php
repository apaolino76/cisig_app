<?php

if (!function_exists('limpa_mascara')) 
{
    function limpa_mascara(string $valorOriginal): string
    {
        return str_replace(['.', '-'], '', $valorOriginal);
    }
}


