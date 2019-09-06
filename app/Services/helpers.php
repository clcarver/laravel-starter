<?php
if (!function_exists('dollarsToCents')) {
    function dollarsToCents($cents)
    {
        return intval(
            strval(floatval(
                    preg_replace("/[^0-9.]/", "", str_replace(',', '.', $cents))
                ) * 100));
    }
}