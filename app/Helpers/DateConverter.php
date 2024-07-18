<?php 

namespace App\Helpers;

use DateTime;

class DateConverter
{
    public static function dateExcelToBdFormater(string $date): string
    {
        $data_numerica = intval($date);
        $data_formatada = new DateTime("1899-12-30 + $data_numerica  days");
        return $data_formatada->format('Y-m-d');
    }
}