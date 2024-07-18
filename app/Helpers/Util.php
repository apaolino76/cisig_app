<?php

namespace App\Helpers;

class Util
{
    public static function montaCompetencia(string $num1, string $oper) : string
    {
        if ((substr($num1, 4, 2) === '01' && $oper === '-') || (substr($num1, 4, 2) === '12' && $oper === '+')){
            $num2  = 89;
        } else {
            $num2  = 1;
        }
        $valor  = "$num1 $oper $num2";
        $result = eval("return $valor;");
        return strval($result);
    }
}